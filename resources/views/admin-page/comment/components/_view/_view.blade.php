@php
    $contentLabels = [
        'article'     => 'Article',
        'news'        => 'News',
        'event'       => 'Event',
        'catalogBook' => 'Book Catalog',
    ];
    $contentLabel = $contentLabels[$comment->contentType] ?? ucfirst($comment->contentType);

    $badgeMap = [
        'article'     => 'bg-primary',
        'news'        => 'bg-info text-dark',
        'event'       => 'bg-warning text-dark',
        'catalogBook' => 'bg-success',
    ];
    $typeBadge = $badgeMap[$comment->contentType] ?? 'bg-secondary';

    $reactionEmojis = [
        'like'         => ['emoji' => '👍', 'label' => 'Like'],
        'dislike'      => ['emoji' => '👎', 'label' => 'Dislike'],
        'love'         => ['emoji' => '❤️',  'label' => 'Love'],
        'heart_eyes'   => ['emoji' => '😍', 'label' => 'Heart Eyes'],
        'laughing'     => ['emoji' => '😂', 'label' => 'Laughing'],
        'rage'         => ['emoji' => '😡', 'label' => 'Rage'],
        'slight_smile' => ['emoji' => '🙂', 'label' => 'Slight Smile'],
    ];

    $reactionCounts = $comment->reactions->groupBy('reactionType')
        ->map(function ($group) { return $group->count(); });

    $totalReactions = $reactionCounts->sum();

    // Count all replies including level-2
    $directReplies = $comment->replies->count();
    $nestedReplies = 0;
    foreach ($comment->replies as $r) { $nestedReplies += $r->replies->count(); }
    $totalRepliesCount = $directReplies + $nestedReplies;

    $user    = $comment->user;
    $profile = $user->profile ?? null;
    if ($profile && $profile->profilepicture) {
        $avatarSrc = 'https://lh3.googleusercontent.com/d/' . $profile->gdrive_id;
    } elseif ($profile && $profile->googleAvatar) {
        $avatarSrc = $profile->googleAvatar;
    } else {
        $avatarSrc = null;
    }
@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">

            {{-- Page Title --}}
            <div class="col-12 text-center">
                <h1 class="page-title">
                    <i class="fas fa-eye me-2"></i>
                    <span>View</span>
                    <span class="highlighted-text ms-1">Comment</span>
                    <small>ID #{{ $comment->commentID }} &mdash; by {{ $user->name }}</small>
                </h1>
            </div>

            {{-- Main Card --}}
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row">

                            {{-- Left: Comment Information (col-8) --}}
                            <div class="col-md-8">
                                <h5 class="section-title mb-3">
                                    <i class="fas fa-info-circle me-2"></i>Comment Information
                                </h5>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Posted By</label>
                                        <div class="form-control-plaintext d-flex align-items-center gap-2">
                                            @if($avatarSrc)
                                                <img src="{{ $avatarSrc }}" alt="{{ $user->name }}"
                                                     style="width:32px;height:32px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                                            @else
                                                <div style="width:32px;height:32px;border-radius:50%;background:#00a79d;color:#fff;
                                                            display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">
                                                    {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-semibold" style="font-size:.9rem">{{ $user->name }}</div>
                                                <div class="text-muted" style="font-size:.78rem">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Content Type</label>
                                        <div class="form-control-plaintext">
                                            <span class="badge {{ $typeBadge }}">{{ $contentLabel }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">Content ID</label>
                                        <div class="form-control-plaintext">#{{ $comment->contentID }}</div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">Posted At</label>
                                        <div class="form-control-plaintext">
                                            {{ $comment->createdDate ? $comment->createdDate->isoFormat('DD MMM YYYY') : '—' }}
                                            <small class="text-muted ms-1">
                                                ({{ $comment->createdDate ? $comment->createdDate->format('H:i') : '' }})
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">Total Replies</label>
                                        <div class="form-control-plaintext">
                                            {{ $totalRepliesCount }}
                                            <small class="text-muted ms-1">
                                                repl{{ $totalRepliesCount === 1 ? 'y' : 'ies' }}
                                                @if($nestedReplies > 0)
                                                    ({{ $directReplies }} direct + {{ $nestedReplies }} nested)
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Comment Text</label>
                                    @if($comment->commentText)
                                        <div class="form-control-plaintext cmtv-body-text">{{ $comment->commentText }}</div>
                                    @else
                                        <div class="form-control-plaintext text-muted fst-italic">— (no text, media only)</div>
                                    @endif
                                </div>

                                {{-- Reactions --}}
                                @if($totalReactions > 0)
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Reactions
                                        <span class="badge bg-secondary ms-1">{{ $totalReactions }}</span>
                                    </label>
                                    <div class="form-control-plaintext d-flex flex-wrap gap-2">
                                        @foreach($reactionEmojis as $type => $rx)
                                            @if(isset($reactionCounts[$type]) && $reactionCounts[$type] > 0)
                                            <span class="cmtv-rx-pill" title="{{ $rx['label'] }}">
                                                {{ $rx['emoji'] }}
                                                <span class="cmtv-rx-count">{{ $reactionCounts[$type] }}</span>
                                            </span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>

                            {{-- Right: Media (col-4) --}}
                            <div class="col-md-4">
                                <h5 class="section-title mb-3">
                                    <i class="fas fa-paperclip me-2"></i>Attached Media
                                </h5>

                                @if($comment->mediaUrl)
                                <div class="mb-2">
                                    <label class="form-label fw-bold">
                                        Type
                                        <span class="badge bg-secondary ms-1">{{ $comment->mediaType }}</span>
                                    </label>
                                    <div class="cmtv-media-wrap mt-1">
                                        <img src="{{ $comment->mediaUrl }}"
                                             alt="Attached media"
                                             class="cmtv-media-img"
                                             onclick="this.requestFullscreen && this.requestFullscreen()">
                                    </div>
                                </div>
                                @else
                                <div class="d-flex flex-column align-items-center justify-content-center h-75 text-muted" style="min-height:120px">
                                    <i class="fas fa-image fa-2x mb-2 opacity-25"></i>
                                    <span class="small">No media attached</span>
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Replies Card --}}
            @if($comment->replies->count() > 0)
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3">
                            <i class="fas fa-reply me-2"></i>
                            Replies
                            <span class="badge bg-secondary ms-2" style="font-size:.72rem">{{ $comment->replies->count() }}</span>
                        </h5>

                        @foreach($comment->replies as $reply)
                        @php
                            $rUser    = $reply->user;
                            $rProfile = $rUser->profile ?? null;
                            if ($rProfile && $rProfile->profilepicture) {
                                $rAvatar = 'https://lh3.googleusercontent.com/d/' . $rProfile->gdrive_id;
                            } elseif ($rProfile && $rProfile->googleAvatar) {
                                $rAvatar = $rProfile->googleAvatar;
                            } else {
                                $rAvatar = null;
                            }
                            $rRxCounts = $reply->reactions->groupBy('reactionType')->map(function ($g) { return $g->count(); });
                            $rRxTotal  = $rRxCounts->sum();
                        @endphp

                        <div class="cmtv-reply-row {{ !$loop->last ? 'border-bottom pb-3 mb-3' : '' }}">
                            {{-- Reply Author --}}
                            <div class="d-flex align-items-center gap-2 mb-2">
                                @if($rAvatar)
                                    <img src="{{ $rAvatar }}" alt="{{ $rUser->name }}"
                                         style="width:30px;height:30px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                                @else
                                    <div style="width:30px;height:30px;border-radius:50%;background:#00a79d;color:#fff;
                                                display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.75rem;flex-shrink:0;">
                                        {{ mb_strtoupper(mb_substr($rUser->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="fw-semibold" style="font-size:.87rem">{{ $rUser->name }}</span>
                                <span class="text-muted" style="font-size:.75rem">
                                    {{ $reply->createdDate ? $reply->createdDate->isoFormat('DD MMM YYYY, HH:mm') : '—' }}
                                </span>
                                <span class="badge bg-light text-secondary border" style="font-size:.67rem">ID #{{ $reply->commentID }}</span>
                            </div>

                            {{-- Reply text --}}
                            @if($reply->commentText)
                                <p class="cmtv-body-text mb-1 ms-5">{{ $reply->commentText }}</p>
                            @endif

                            @if($reply->mediaUrl)
                                <img src="{{ $reply->mediaUrl }}" alt="media" class="cmtv-media-img cmtv-media-sm ms-5 mt-1">
                            @endif

                            @if($rRxTotal > 0)
                            <div class="d-flex flex-wrap gap-1 ms-5 mt-1">
                                @foreach($reactionEmojis as $type => $rx)
                                    @if(isset($rRxCounts[$type]) && $rRxCounts[$type] > 0)
                                    <span class="cmtv-rx-pill" title="{{ $rx['label'] }}">
                                        {{ $rx['emoji'] }} <span class="cmtv-rx-count">{{ $rRxCounts[$type] }}</span>
                                    </span>
                                    @endif
                                @endforeach
                            </div>
                            @endif

                            {{-- Level-2 replies --}}
                            @if($reply->replies->count() > 0)
                            <div class="cmtv-l2-wrap ms-5 mt-2">
                                @foreach($reply->replies as $deep)
                                @php
                                    $dUser    = $deep->user;
                                    $dProfile = $dUser->profile ?? null;
                                    if ($dProfile && $dProfile->profilepicture) {
                                        $dAvatar = 'https://lh3.googleusercontent.com/d/' . $dProfile->gdrive_id;
                                    } elseif ($dProfile && $dProfile->googleAvatar) {
                                        $dAvatar = $dProfile->googleAvatar;
                                    } else {
                                        $dAvatar = null;
                                    }
                                @endphp
                                <div class="cmtv-l2-row {{ !$loop->last ? 'mb-2' : '' }}">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        @if($dAvatar)
                                            <img src="{{ $dAvatar }}" alt="{{ $dUser->name }}"
                                                 style="width:24px;height:24px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                                        @else
                                            <div style="width:24px;height:24px;border-radius:50%;background:#64748b;color:#fff;
                                                        display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.65rem;flex-shrink:0;">
                                                {{ mb_strtoupper(mb_substr($dUser->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span class="fw-semibold" style="font-size:.82rem">{{ $dUser->name }}</span>
                                        <span class="text-muted" style="font-size:.72rem">
                                            {{ $deep->createdDate ? $deep->createdDate->isoFormat('DD MMM YYYY, HH:mm') : '—' }}
                                        </span>
                                        <span class="badge bg-light text-secondary border" style="font-size:.62rem">ID #{{ $deep->commentID }}</span>
                                    </div>
                                    @if($deep->commentText)
                                        <p class="cmtv-body-text mb-0 ms-4" style="font-size:.84rem">{{ $deep->commentText }}</p>
                                    @endif
                                    @if($deep->mediaUrl)
                                        <img src="{{ $deep->mediaUrl }}" alt="media" class="cmtv-media-img cmtv-media-sm ms-4 mt-1">
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
            @endif

            {{-- Bottom Actions --}}
            <div class="col-12 d-flex justify-content-end mb-4">
                <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>

        </div>
    </div>
</div>
