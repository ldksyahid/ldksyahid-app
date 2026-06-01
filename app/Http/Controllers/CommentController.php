<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReaction;
use App\Services\GoogleDrive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
            'createdAt'     => $comment->createdDate ? $comment->createdDate->diffForHumans() : '-',
            'parentID'      => $comment->parentID,
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
