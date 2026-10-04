<?php

declare(strict_types=1);

namespace App\Livewire\Community;

use App\Actions\Community\CreateCommentAction;
use App\Actions\Community\CreatePostAction;
use App\Models\CommunityGroup;
use App\Models\CommunityPost;
use App\Models\ModerationReport;
use App\Models\PostReaction;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SquadFeed extends Component
{
    public Collection $groups;
    public ?CommunityGroup $activeGroup = null;

    // Post Creation
    public string $postContent = '';

    // Commenting
    public ?int $expandedPostId = null;
    public string $commentContent = '';

    // Reporting Modal State
    public ?int $reportingPostId = null;
    public string $reportReason = 'self_harm_risk';
    public bool $reportSubmitted = false;

    public function mount(): void
    {
        $this->groups = CommunityGroup::where('is_private', false)->get();
        $this->activeGroup = $this->groups->first();
    }

    public function selectGroup(int $groupId): void
    {
        $this->activeGroup = CommunityGroup::findOrFail($groupId);
        $this->expandedPostId = null;
        $this->reset(['postContent', 'commentContent', 'reportingPostId', 'reportSubmitted']);
    }

    public function publishPost(CreatePostAction $createAction): void
    {
        $this->validate([
            'postContent' => ['required', 'string', 'min:3', 'max:2000'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Automatically filtered and scanned by ContentSentinel in CreatePostAction
        $post = $createAction->execute($user, $this->activeGroup, $this->postContent);

        $this->reset('postContent');

        if ($post->is_quarantined) {
            session()->flash('squad_notice', 'Post received and held for brief clinical moderator review.');
        } else {
            session()->flash('squad_notice', 'Operational update published to squad feed.');
        }
    }

    public function toggleReaction(int $postId, string $type): void
    {
        if (!in_array($type, ['solidarity', 'heard', 'respect'], true)) {
            return;
        }

        /** @var User $user */
        $user = Auth::user();

        $existing = PostReaction::where('post_id', $postId)
            ->where('user_id', $user->id)
            ->where('reaction_type', $type)
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            PostReaction::create([
                'post_id' => $postId,
                'user_id' => $user->id,
                'reaction_type' => $type,
            ]);
        }
    }

    public function toggleComments(int $postId): void
    {
        $this->expandedPostId = $this->expandedPostId === $postId ? null : $postId;
        $this->commentContent = '';
    }

    public function addComment(int $postId, CreateCommentAction $commentAction): void
    {
        $this->validate([
            'commentContent' => ['required', 'string', 'min:2', 'max:1000'],
        ]);

        /** @var User $user */
        $user = Auth::user();
        $post = CommunityPost::findOrFail($postId);

        $commentAction->execute($user, $post, $this->commentContent);

        $this->reset('commentContent');
    }

    public function openReportModal(int $postId): void
    {
        $this->reportingPostId = $postId;
        $this->reportReason = 'self_harm_risk';
        $this->reportSubmitted = false;
    }

    public function submitReport(): void
    {
        if (!$this->reportingPostId) {
            return;
        }

        /** @var User $user */
        $user = Auth::user();

        ModerationReport::create([
            'reporter_user_id' => $user->id,
            'reportable_type' => CommunityPost::class,
            'reportable_id' => $this->reportingPostId,
            'reason' => $this->reportReason,
            'status' => 'pending',
        ]);

        $this->reportSubmitted = true;
    }

    public function closeReportModal(): void
    {
        $this->reportingPostId = null;
        $this->reportSubmitted = false;
    }

    public function render(): View
    {
        $posts = collect();

        if ($this->activeGroup) {
            // Strictly fetch visible, non-quarantined posts
            $posts = CommunityPost::where('group_id', $this->activeGroup->id)
                ->where('is_quarantined', false)
                ->with([
                    'user.profile',
                    'reactions',
                    'comments' => fn ($q) => $q->where('is_quarantined', false)->with('user.profile')->latest(),
                ])
                ->latest()
                ->get();
        }

        return view('livewire.community.squad-feed', [
            'posts' => $posts,
        ]);
    }
}