<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReaction;
use App\Services\GoogleDrive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    // Google Drive folder ID for comment media
    const GDRIVE_FOLDER = '15ZcTt7GLftr8P4OC7HVQzhuYnxkr2CMJ';

    // Supported reaction types
    const REACTION_TYPES = ['like','dislike','love','heart_eyes','laughing','rage','slight_smile'];

    // ── Load comments (GET) ──────────────────────────────────────────
    public function index(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:50',
            'id'   => 'required|integer|min:1',
        ]);

        $comments = Comment::with([
                'user.profile',
                'replies.user.profile',
                'replies.replies.user.profile',
            ])
            ->whereNull('parentID')
            ->where('contentType', $request->type)
            ->where('contentID', $request->id)
            ->orderBy('createdDate', 'desc')
            ->get();

        $allIds = $this->collectAllIds($comments);
        $userId = Auth::id();

        // Single query: all reaction counts grouped by comment + type
        $reactionCounts = [];
        $userReactionMap = [];

        if (!empty($allIds)) {
            $rows = CommentReaction::whereIn('commentID', $allIds)
                ->selectRaw('commentID, reactionType, COUNT(*) as cnt')
                ->groupBy('commentID', 'reactionType')
                ->get();

            foreach ($rows as $row) {
                $cid = $row->commentID;
                if (!isset($reactionCounts[$cid])) {
                    $reactionCounts[$cid] = [];
                }
                $reactionCounts[$cid][$row->reactionType] = (int) $row->cnt;
            }

            if ($userId) {
                $userRows = CommentReaction::where('userID', $userId)
                    ->whereIn('commentID', $allIds)
                    ->get();

                foreach ($userRows as $row) {
                    $cid = $row->commentID;
                    if (!isset($userReactionMap[$cid])) {
                        $userReactionMap[$cid] = [];
                    }
                    $userReactionMap[$cid][] = $row->reactionType;
                }
            }
        }

        $self = $this;
        return response()->json(
            $comments->map(function ($c) use ($self, $reactionCounts, $userReactionMap) {
                return $self->formatComment($c, $reactionCounts, $userReactionMap);
            })
        );
    }

    // ── Post a new comment or reply (POST) ───────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'type'        => 'required|string|max:50',
            'id'          => 'required|integer|min:1',
            'commentText' => 'nullable|string|max:2000',
            'parentID'    => 'nullable|integer|exists:tr_comment,commentID',
            'mediaUrl'    => 'nullable|string|max:2000',
            'mediaType'   => 'nullable|in:image,gif,sticker',
            'mediaGdriveId' => 'nullable|string|max:100',
        ]);

        if (empty($request->commentText) && empty($request->mediaUrl)) {
            return response()->json(['message' => 'Komentar atau media wajib diisi.'], 422);
        }

        $comment = Comment::create([
            'userID'        => Auth::id(),
            'contentType'   => $request->type,
            'contentID'     => $request->id,
            'parentID'      => $request->parentID,
            'commentText'   => $request->commentText ?: '',
            'mediaUrl'      => $request->mediaUrl,
            'mediaType'     => $request->mediaType,
            'mediaGdriveId' => $request->mediaGdriveId,
        ]);

        $comment->load(['user.profile']);
        return response()->json($this->formatComment($comment), 201);
    }

    // ── Toggle one reaction type (POST) ─────────────────────────────
    // Users can hold multiple different reaction types simultaneously.
    public function react(Request $request, $commentId)
    {
        $request->validate([
            'type' => 'required|in:' . implode(',', self::REACTION_TYPES),
        ]);

        $userId = Auth::id();
        $type   = $request->type;

        $existing = CommentReaction::where('commentID', $commentId)
            ->where('userID', $userId)
            ->where('reactionType', $type)
            ->first();

        if ($existing) {
            $existing->delete();
            $action = 'removed';
        } else {
            CommentReaction::create([
                'commentID'    => $commentId,
                'userID'       => $userId,
                'reactionType' => $type,
            ]);
            $action = 'added';
        }

        // Return fresh counts and current user's active types
        $counts = CommentReaction::where('commentID', $commentId)
            ->selectRaw('reactionType, COUNT(*) as cnt')
            ->groupBy('reactionType')
            ->pluck('cnt', 'reactionType')
            ->toArray();

        $userTypes = CommentReaction::where('commentID', $commentId)
            ->where('userID', $userId)
            ->pluck('reactionType')
            ->toArray();

        return response()->json([
            'action'    => $action,
            'type'      => $type,
            'counts'    => $counts,
            'userTypes' => $userTypes,
        ]);
    }

    // ── Upload image to Google Drive (POST) ──────────────────────────
    public function uploadMedia(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,webp,gif|max:5120',
        ]);

        $file     = $request->file('file');
        $ext      = strtolower($file->getClientOriginalExtension());
        $fileName = time() . '_cmt_' . uniqid() . '.' . $ext;
        $filePath = self::GDRIVE_FOLDER . '/' . $fileName;

        try {
            $gdrive = new GoogleDrive(self::GDRIVE_FOLDER);
            $result = $gdrive->uploadFile($file, $fileName, $filePath);
            $type   = ($ext === 'gif') ? 'gif' : 'image';

            return response()->json([
                'url'       => 'https://lh3.googleusercontent.com/d/' . $result['gdriveID'],
                'type'      => $type,
                'gdriveId'  => $result['gdriveID'],
            ]);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Gagal mengunggah file ke Google Drive.'], 500);
        }
    }

    // ── Search GIFs / Stickers via GIPHY API (GET) ───────────────────
    // Requires GIPHY_API_KEY in .env — get free key at developers.giphy.com
    public function gifSearch(Request $request)
    {
        $query  = trim($request->query('q', ''));
        $tab    = $request->query('tab', 'gifs');   // 'gifs' or 'stickers'
        $apiKey = env('GIPHY_API_KEY', '');

        if (!$apiKey) {
            return response()->json(['data' => [], 'error' => 'GIPHY_API_KEY belum dikonfigurasi di .env']);
        }

        $type   = ($tab === 'stickers') ? 'stickers' : 'gifs';
        $action = empty($query) ? 'trending' : 'search';
        $params = ['api_key' => $apiKey, 'limit' => 24, 'rating' => 'g', 'lang' => 'id'];
        if ($action === 'search') {
            $params['q'] = $query;
        }

        try {
            $res = Http::timeout(6)->get("https://api.giphy.com/v1/{$type}/{$action}", $params);

            if (!$res->successful()) {
                return response()->json(['data' => []]);
            }

            $items = array_map(function ($item) {
                $imgs = isset($item['images']) ? $item['images'] : [];
                return [
                    'id'      => $item['id'],
                    'preview' => isset($imgs['fixed_height_small']['url'])
                                    ? $imgs['fixed_height_small']['url']
                                    : (isset($imgs['downsized']['url']) ? $imgs['downsized']['url'] : ''),
                    'url'     => isset($imgs['original']['url']) ? $imgs['original']['url'] : '',
                    'title'   => isset($item['title']) ? $item['title'] : '',
                ];
            }, $res->json('data', []));

            return response()->json(['data' => $items]);
        } catch (\Exception $e) {
            return response()->json(['data' => []]);
        }
    }

    // ── Get trending GIF category tags (GET) ─────────────────────────
    public function gifCategories(Request $request)
    {
        $apiKey = env('GIPHY_API_KEY', '');
        if (!$apiKey) {
            return response()->json(['data' => []]);
        }

        try {
            $res = Http::timeout(5)->get('https://api.giphy.com/v1/gifs/categories', [
                'api_key' => $apiKey,
            ]);

            if (!$res->successful()) {
                return response()->json(['data' => []]);
            }

            $cats = array_slice($res->json('data', []), 0, 8);
            $result = array_map(function ($c) {
                return [
                    'name' => $c['name'],
                    'slug' => isset($c['name_encoded']) ? $c['name_encoded'] : $c['name'],
                ];
            }, $cats);

            return response()->json(['data' => $result]);
        } catch (\Exception $e) {
            return response()->json(['data' => []]);
        }
    }

    // ── Edit own comment (PUT) ───────────────────────────────────────
    public function update(Request $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if ((int) $comment->userID !== (int) Auth::id()) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $request->validate([
            'commentText'   => 'nullable|string|max:2000',
            'mediaUrl'      => 'nullable|string|max:2000',
            'mediaType'     => 'nullable|in:image,gif,sticker',
            'mediaGdriveId' => 'nullable|string|max:100',
        ]);

        if (empty($request->commentText) && empty($request->mediaUrl)) {
            return response()->json(['message' => 'Komentar atau media wajib diisi.'], 422);
        }

        // Delete old GDrive image if replaced or removed
        $oldGdriveId = $comment->mediaGdriveId;
        $newGdriveId = $request->mediaGdriveId;
        if ($oldGdriveId && $oldGdriveId !== $newGdriveId && $comment->mediaType === 'image') {
            try {
                (new GoogleDrive(self::GDRIVE_FOLDER))->deleteFile($oldGdriveId);
            } catch (\Exception $ignored) {}
        }

        $comment->update([
            'commentText'   => $request->commentText ?: '',
            'mediaUrl'      => $request->mediaUrl,
            'mediaType'     => $request->mediaType,
            'mediaGdriveId' => $request->mediaGdriveId,
        ]);

        $comment->load(['user.profile']);
        return response()->json($this->formatComment($comment));
    }

    // ── Delete own comment (DELETE) ──────────────────────────────────
    public function destroy($commentId)
    {
        try {
            $comment = Comment::with('replies.replies')->findOrFail($commentId);

            if ((int) $comment->userID !== (int) Auth::id()) {
                return response()->json(['message' => 'Forbidden.'], 403);
            }

            $allIds = $this->collectAllIds(collect([$comment]));
            $this->deleteGdriveMedia($allIds);

            CommentReaction::whereIn('commentID', $allIds)->delete();
            Comment::whereIn('commentID', array_diff($allIds, [$comment->commentID]))->delete();
            $comment->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('[CommentController] destroy: ' . $e->getMessage(), ['id' => $commentId]);
            return response()->json(['success' => false, 'message' => 'Gagal menghapus komentar.'], 500);
        }
    }

    // ════════════════════════════════════════════════════════════════
    //  ADMIN — Comment Control Center (Superadmin only)
    // ════════════════════════════════════════════════════════════════

    public function indexAdmin(Request $request)
    {
        $query = Comment::with(['user.profile'])
            ->whereNull('parentID');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('commentText', 'like', "%{$s}%")
                  ->orWhereHas('user', function ($u) use ($s) {
                      $u->where('name', 'like', "%{$s}%");
                  });
            });
        }

        if ($request->filled('contentType')) {
            $query->where('contentType', $request->contentType);
        }

        if ($request->filled('mediaType')) {
            if ($request->mediaType === 'none') {
                $query->whereNull('mediaUrl');
            } else {
                $query->where('mediaType', $request->mediaType);
            }
        }

        if ($request->filled('createdDate')) {
            $parts = explode(' - ', $request->createdDate);
            if (count($parts) === 2) {
                $query->whereDate('createdDate', '>=', trim($parts[0]))
                      ->whereDate('createdDate', '<=', trim($parts[1]));
            }
        }

        $sortBy    = in_array($request->sort_by, ['createdDate', 'contentType', 'commentText']) ? $request->sort_by : 'createdDate';
        $sortOrder = $request->sort_order === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortOrder);

        $items = $query->paginate(20)->appends($request->query());

        $tableConfig = [
            'idKey'        => 'commentID',
            'emptyMessage' => 'No comments found.',
            'emptyIcon'    => 'fa-comments',
            'colspan'      => 8,
            'columns'      => [
                ['key' => 'user.name',    'type' => 'relation', 'relationKey' => 'user.name',    'class' => 'text-start', 'fallback' => '—'],
                ['key' => 'contentType',  'type' => 'badge',    'class' => 'text-center',
                    'badgeMap'     => ['article' => 'bg-primary', 'news' => 'bg-info text-dark', 'event' => 'bg-warning text-dark', 'catalogBook' => 'bg-success'],
                    'badgeDefault' => 'bg-secondary'],
                ['key' => 'commentText',  'type' => 'text',     'class' => 'text-start cmt-admin-truncate', 'fallback' => '—'],
                ['key' => 'mediaType',    'type' => 'badge',    'class' => 'text-center',
                    'badgeMap'     => ['image' => 'bg-primary', 'gif' => 'bg-warning text-dark', 'sticker' => 'bg-success'],
                    'badgeDefault' => 'bg-secondary', 'fallback' => '—'],
                ['key' => 'createdDate',  'type' => 'datetime', 'dateFormat' => 'DD MMM YYYY', 'class' => 'text-center'],
            ],
            'actions' => [
                'view'   => ['enabled' => true, 'route' => 'admin.comments.show', 'routeKey' => 'commentID', 'class' => 'btn-custom-primary'],
                'delete' => ['enabled' => true, 'class' => 'btn-custom-primary'],
            ],
        ];

        if ($request->ajax()) {
            return response()->json([
                'tableBody'  => view('components.admin-index.index-table', compact('items', 'tableConfig'))->render(),
                'pagination' => $items->appends($request->query())->links()->render(),
                'total'      => $items->total(),
                'from'       => $items->firstItem(),
                'to'         => $items->lastItem(),
            ]);
        }

        $contentTypeOptions = Comment::whereNull('parentID')
            ->distinct()->pluck('contentType')
            ->mapWithKeys(function ($t) { return [$t => ucfirst($t)]; })->toArray();

        $mediaTypeOptions = ['image' => 'Image', 'gif' => 'GIF', 'sticker' => 'Sticker', 'none' => 'No Media'];

        return view('admin-page.comment.index', compact('items', 'tableConfig', 'contentTypeOptions', 'mediaTypeOptions'))
            ->with('title', 'Comment Control Center');
    }

    public function showAdmin($id)
    {
        $comment = Comment::with([
            'user.profile',
            'reactions',
            'replies.user.profile',
            'replies.reactions',
            'replies.replies.user.profile',
            'replies.replies.reactions',
        ])->findOrFail($id);

        return view('admin-page.comment.view', compact('comment'))
            ->with('title', 'Comment Detail');
    }

    public function destroyAdmin($id)
    {
        try {
            $comment = Comment::with('replies.replies')->findOrFail($id);

            $allIds = $this->collectAllIds(collect([$comment]));

            // Delete all GDrive media files (main comment + all nested replies)
            $this->deleteGdriveMedia($allIds);

            CommentReaction::whereIn('commentID', $allIds)->delete();
            Comment::whereIn('commentID', array_diff($allIds, [$comment->commentID]))->delete();
            $comment->delete();

            return response()->json(['success' => true, 'message' => 'Comment deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('[CommentController] destroyAdmin: ' . $e->getMessage(), ['id' => $id]);
            return response()->json(['success' => false, 'message' => 'Failed to delete comment.'], 500);
        }
    }

    public function bulkDeleteAdmin(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            if (empty($ids)) {
                return response()->json(['success' => false, 'message' => 'No comments selected.'], 400);
            }

            $comments = Comment::with('replies.replies')->whereIn('commentID', $ids)->get();
            $allIds   = [];
            foreach ($comments as $c) {
                $allIds = array_merge($allIds, $this->collectAllIds(collect([$c])));
            }
            $allIds = array_unique($allIds);

            // Delete all GDrive media files across the whole batch
            $this->deleteGdriveMedia($allIds);

            CommentReaction::whereIn('commentID', $allIds)->delete();
            Comment::whereIn('commentID', $allIds)->delete();

            return response()->json(['success' => true, 'message' => count($ids) . ' comment(s) deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('[CommentController] bulkDeleteAdmin: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to bulk delete.'], 500);
        }
    }

    // Delete GDrive files for any comments in $commentIds that have a stored image
    private function deleteGdriveMedia(array $commentIds)
    {
        $mediaIds = Comment::whereIn('commentID', $commentIds)
            ->whereNotNull('mediaGdriveId')
            ->where('mediaType', 'image')
            ->pluck('mediaGdriveId');

        if ($mediaIds->isEmpty()) return;

        $gdrive = new GoogleDrive(self::GDRIVE_FOLDER);
        foreach ($mediaIds as $gdriveId) {
            try {
                $gdrive->deleteFile($gdriveId);
            } catch (\Exception $ignored) {}
        }
    }

    // ── Format one comment for JSON output ───────────────────────────
    public function formatComment(Comment $comment, $reactionCounts = [], $userReactionMap = [])
    {
        $user    = $comment->user;
        $profile = isset($user->profile) ? $user->profile : null;

        if ($profile && $profile->profilepicture) {
            $avatar = 'https://lh3.googleusercontent.com/d/' . $profile->gdrive_id;
        } elseif ($profile && $profile->googleAvatar) {
            $avatar = $profile->googleAvatar;
        } else {
            $avatar = null;
        }

        $replies = [];
        if ($comment->relationLoaded('replies')) {
            $self    = $this;
            $replies = $comment->replies
                ->map(function ($r) use ($self, $reactionCounts, $userReactionMap) {
                    return $self->formatComment($r, $reactionCounts, $userReactionMap);
                })
                ->values()
                ->toArray();
        }

        $cid       = $comment->commentID;
        $counts    = isset($reactionCounts[$cid]) ? $reactionCounts[$cid] : [];
        $userTypes = isset($userReactionMap[$cid]) ? $userReactionMap[$cid] : [];

        return [
            'id'            => $cid,
            'commentText'   => $comment->commentText,
            'mediaUrl'      => $comment->mediaUrl,
            'mediaType'     => $comment->mediaType,
            'mediaGdriveId' => $comment->mediaGdriveId,
            'createdAt'     => $comment->createdDate ? $comment->createdDate->diffForHumans() : '-',
            'parentID'      => $comment->parentID,
            'isOwner'       => Auth::id() !== null && (int) $comment->userID === (int) Auth::id(),
            'reactions'     => ['counts' => $counts, 'userTypes' => $userTypes],
            'user'          => ['id' => $user->id, 'name' => $user->name, 'avatar' => $avatar],
            'replies'       => $replies,
        ];
    }

    // ── Helpers ──────────────────────────────────────────────────────

    private function collectAllIds($comments)
    {
        $ids = [];
        foreach ($comments as $c) {
            $ids[] = $c->commentID;
            if ($c->relationLoaded('replies')) {
                foreach ($c->replies as $r) {
                    $ids[] = $r->commentID;
                    if ($r->relationLoaded('replies')) {
                        foreach ($r->replies as $rr) {
                            $ids[] = $rr->commentID;
                        }
                    }
                }
            }
        }
        return $ids;
    }
}
