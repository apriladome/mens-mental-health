<div class="mx-auto max-w-5xl py-8 px-4">
    <!-- Feedback Notice -->
    @if(session()->has('squad_notice'))
        <div class="mb-6 rounded-lg border border-tactical-steel/30 bg-tactical-steel/10 p-4 text-xs font-mono text-tactical-steel flex items-center justify-between">
            <span>{{ session('squad_notice') }}</span>
            <button type="button" @click="$el.parentElement.remove()" class="text-content-muted hover:text-content-primary">✕</button>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Sidebar: Squad Channels List -->
        <div class="md:col-span-1 space-y-2">
            <div class="text-xs font-mono text-tactical-steel mb-3 px-1">COMMUNITY SQUADS</div>

            @foreach($groups as $group)
                <button 
                    type="button"
                    wire:click="selectGroup({{ $group->id }})"
                    class="w-full text-left p-3 rounded-lg border transition text-xs font-mono {{ $activeGroup && $activeGroup->id === $group->id ? 'border-tactical-steel bg-tactical-steel/10 text-tactical-steel font-bold shadow-sm' : 'border-surface-border bg-surface-card text-content-secondary hover:bg-surface-hover hover:text-content-primary' }}"
                >
                    <div class="truncate"># {{ $group->name }}</div>
                </button>
            @endforeach

            <!-- Squad Culture Card -->
            <div class="mt-6 rounded-lg border border-surface-border bg-surface-base p-4 text-[11px] text-content-muted leading-relaxed">
                <span class="text-content-secondary font-bold font-mono">SQUAD PROTOCOL:</span>
                <ul class="mt-2 space-y-1 list-disc list-inside">
                    <li>Zero vanity algorithms</li>
                    <li>No legal names or contact info</li>
                    <li>Speak directly; no advice unless requested</li>
                    <li>Report any member showing acute self-harm</li>
                </ul>
            </div>
        </div>

        <!-- Main Feed Column -->
        <div class="md:col-span-3 space-y-6">
            <!-- Active Squad Briefing Header -->
            @if($activeGroup)
                <div class="rounded-xl border border-surface-border bg-surface-card p-6 shadow-xl">
                    <div class="text-xs font-mono text-tactical-steel uppercase">ACTIVE SQUAD CHANNEL</div>
                    <h1 class="text-2xl font-extrabold text-content-primary mt-1">{{ $activeGroup->name }}</h1>
                    <p class="mt-1 text-xs text-content-secondary leading-relaxed">{{ $activeGroup->description }}</p>

                    <!-- Publish Form -->
                    <form wire:submit.prevent="publishPost" class="mt-6 border-t border-surface-border pt-4">
                        <textarea 
                            wire:model="postContent"
                            rows="3" 
                            placeholder="Share an operational win, a point of friction, or tactical insight..."
                            class="w-full rounded-lg border border-surface-border bg-surface-base p-3 text-xs sm:text-sm text-content-primary focus:border-tactical-steel focus:ring-1 focus:ring-tactical-steel resize-none placeholder:text-content-muted"
                        ></textarea>
                        @error('postContent') <div class="mt-1 text-xs text-tactical-danger font-mono">{{ $message }}</div> @enderror

                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-[11px] font-mono text-content-muted">
                                POSTING AS: <strong class="text-tactical-steel">{{ auth()->user()?->profile?->public_handle ?? 'Guest' }}</strong>
                            </span>
                            <button 
                                type="submit" 
                                class="rounded-lg bg-content-primary px-5 py-2 text-xs font-mono font-bold text-surface-base hover:bg-white transition"
                            >
                                Dispatch Post ➔
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Posts List -->
            <div class="space-y-4">
                @forelse($posts as $post)
                    @php
                        $handle = $post->user?->profile?->public_handle ?? 'Anonymous_Member';
                        $solidarityCount = $post->reactions->where('reaction_type', 'solidarity')->count();
                        $heardCount = $post->reactions->where('reaction_type', 'heard')->count();
                        $respectCount = $post->reactions->where('reaction_type', 'respect')->count();
                        $userId = auth()->id();
                        $hasSolidarity = $post->reactions->where('user_id', $userId)->where('reaction_type', 'solidarity')->isNotEmpty();
                        $hasHeard = $post->reactions->where('user_id', $userId)->where('reaction_type', 'heard')->isNotEmpty();
                        $hasRespect = $post->reactions->where('user_id', $userId)->where('reaction_type', 'respect')->isNotEmpty();
                    @endphp

                    <div class="rounded-xl border border-surface-border bg-surface-card p-6 shadow-md transition hover:border-surface-hover">
                        <!-- Post Meta -->
                        <div class="flex items-center justify-between border-b border-surface-border pb-3 mb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="h-7 w-7 rounded bg-surface-base border border-surface-border flex items-center justify-center font-mono text-xs font-bold text-tactical-steel">
                                    {{ strtoupper(substr($handle, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="text-xs font-mono font-bold text-content-primary">{{ $handle }}</div>
                                    <div class="text-[10px] font-mono text-content-muted">{{ $post->created_at->diffForHumans() }}</div>
                                </div>
                            </div>

                            <!-- In-line Report Flag -->
                            <button 
                                type="button" 
                                wire:click="openReportModal({{ $post->id }})"
                                class="text-[11px] font-mono text-content-muted hover:text-tactical-danger transition"
                                title="Report post confidentially"
                            >
                                ⚑ Flag
                            </button>
                        </div>

                        <!-- Post Body -->
                        <div class="text-sm text-content-primary whitespace-pre-line leading-relaxed font-sans">
                            {{ $post->body }}
                        </div>

                        <!-- Vanity-Free Reaction Row -->
                        <div class="mt-6 flex flex-wrap items-center justify-between gap-3 border-t border-surface-border pt-4">
                            <div class="flex items-center gap-2">
                                <!-- Solidarity Button -->
                                <button 
                                    type="button"
                                    wire:click="toggleReaction({{ $post->id }}, 'solidarity')"
                                    class="inline-flex items-center gap-1.5 rounded border px-2.5 py-1 text-xs font-mono transition {{ $hasSolidarity ? 'border-tactical-steel bg-tactical-steel/20 text-tactical-steel font-bold' : 'border-surface-border bg-surface-base text-content-secondary hover:bg-surface-hover' }}"
                                >
                                    <span>🤝 Solidarity</span>
                                    @if($solidarityCount > 0)
                                        <span class="text-[10px] font-bold">{{ $solidarityCount }}</span>
                                    @endif
                                </button>

                                <!-- Heard Button -->
                                <button 
                                    type="button"
                                    wire:click="toggleReaction({{ $post->id }}, 'heard')"
                                    class="inline-flex items-center gap-1.5 rounded border px-2.5 py-1 text-xs font-mono transition {{ $hasHeard ? 'border-tactical-olive bg-tactical-olive/20 text-tactical-olive font-bold' : 'border-surface-border bg-surface-base text-content-secondary hover:bg-surface-hover' }}"
                                >
                                    <span>👂 Heard</span>
                                    @if($heardCount > 0)
                                        <span class="text-[10px] font-bold">{{ $heardCount }}</span>
                                    @endif
                                </button>

                                <!-- Respect Button -->
                                <button 
                                    type="button"
                                    wire:click="toggleReaction({{ $post->id }}, 'respect')"
                                    class="inline-flex items-center gap-1.5 rounded border px-2.5 py-1 text-xs font-mono transition {{ $hasRespect ? 'border-tactical-amber bg-tactical-amber/20 text-tactical-amber font-bold' : 'border-surface-border bg-surface-base text-content-secondary hover:bg-surface-hover' }}"
                                >
                                    <span>🫡 Respect</span>
                                    @if($respectCount > 0)
                                        <span class="text-[10px] font-bold">{{ $respectCount }}</span>
                                    @endif
                                </button>
                            </div>

                            <!-- Comment Thread Toggle -->
                            <button 
                                type="button" 
                                wire:click="toggleComments({{ $post->id }})"
                                class="text-xs font-mono text-content-secondary hover:text-content-primary"
                            >
                                💬 {{ $post->comments->count() }} {{ \Illuminate\Support\Str::plural('Reply', $post->comments->count()) }}
                            </button>
                        </div>

                        <!-- Expanded Comment Thread -->
                        @if($expandedPostId === $post->id)
                            <div class="mt-4 border-t border-surface-border pt-4 space-y-3 bg-surface-base/50 p-4 rounded-lg">
                                <!-- Comment Input -->
                                <div class="flex items-center gap-2">
                                    <input 
                                        type="text" 
                                        wire:model="commentContent"
                                        placeholder="Add an affirming reply..."
                                        class="flex-1 rounded border border-surface-border bg-surface-card p-2 text-xs text-content-primary focus:border-tactical-steel focus:ring-1 focus:ring-tactical-steel"
                                        wire:keydown.enter="addComment({{ $post->id }})"
                                    >
                                    <button 
                                        type="button"
                                        wire:click="addComment({{ $post->id }})"
                                        class="rounded bg-content-primary px-3 py-2 text-xs font-mono font-bold text-surface-base hover:bg-white"
                                    >
                                        Reply
                                    </button>
                                </div>
                                @error('commentContent') <span class="text-[10px] text-tactical-danger font-mono">{{ $message }}</span> @enderror

                                <!-- Comments List -->
                                <div class="space-y-2 mt-3">
                                    @foreach($post->comments as $comment)
                                        <div class="rounded border border-surface-border bg-surface-card p-2.5 text-xs">
                                            <div class="flex items-center justify-between text-[10px] font-mono text-content-muted mb-1">
                                                <span class="text-tactical-steel font-bold">{{ $comment->user?->profile?->public_handle ?? 'Member' }}</span>
                                                <span>{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-content-primary font-sans">{{ $comment->body }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="rounded-xl border border-surface-border bg-surface-card p-8 text-center text-xs font-mono text-content-muted">
                        No updates in this squad channel yet. Be the first to dispatch an update.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Confidential Reporting Modal -->
    @if($reportingPostId)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
            <div class="w-full max-w-md rounded-xl border border-surface-border bg-surface-card p-6 shadow-2xl">
                @if($reportSubmitted)
                    <div class="text-center py-4">
                        <div class="text-tactical-success text-2xl mb-2">✓</div>
                        <h3 class="text-lg font-bold text-content-primary">Report Received Confidentially</h3>
                        <p class="mt-2 text-xs text-content-secondary leading-relaxed">
                            Thank you for protecting your squad. Our clinical moderation team has been notified.
                        </p>
                        <button 
                            type="button" 
                            wire:click="closeReportModal"
                            class="mt-6 rounded bg-content-primary px-4 py-2 text-xs font-mono font-bold text-surface-base"
                        >
                            Close Window
                        </button>
                    </div>
                @else
                    <h3 class="text-lg font-bold text-content-primary">Confidential Safety Flag</h3>
                    <p class="mt-1 text-xs text-content-secondary">
                        Reports are completely anonymous and reviewed promptly by licensed clinical moderators.
                    </p>

                    <div class="mt-4 space-y-2">
                        <label class="block text-xs font-mono text-content-muted mb-1">REASON FOR CONCERN</label>
                        @foreach([
                            'self_harm_risk' => 'Immediate Self-Harm / Crisis Concern',
                            'hate_speech' => 'Hostility, Slurs, or Hate Speech',
                            'harassment' => 'Targeted Harassment or Bullying',
                            'spam' => 'Commercial Solicitation / Spam',
                            'other' => 'Other Breach of Squad Culture',
                        ] as $val => $lbl)
                            <label class="flex items-center gap-2 p-2 rounded border border-surface-border bg-surface-base text-xs text-content-primary cursor-pointer hover:bg-surface-hover">
                                <input type="radio" wire:model="reportReason" value="{{ $val }}" class="accent-tactical-steel">
                                <span>{{ $lbl }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3">
                        <button 
                            type="button" 
                            wire:click="closeReportModal"
                            class="text-xs font-mono text-content-muted hover:text-content-primary"
                        >
                            Cancel
                        </button>
                        <button 
                            type="button" 
                            wire:click="submitReport"
                            class="rounded bg-tactical-danger px-4 py-2 text-xs font-mono font-bold text-white hover:bg-red-600 transition"
                        >
                            Submit Flag
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>