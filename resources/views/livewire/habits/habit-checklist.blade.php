<div class="rounded-xl border border-surface-border bg-surface-card p-6 shadow-xl">
    <div class="flex items-center justify-between border-b border-surface-border pb-4 mb-4">
        <div>
            <div class="text-xs font-mono text-tactical-olive">DAILY RESILIENCE DRILLS</div>
            <h2 class="text-xl font-bold text-content-primary">Keystone Actions</h2>
        </div>
        <span class="text-xs font-mono text-tactical-steel">
            {{ count($completedHabitIds) }}/{{ $habits->count() }} COMPLETE
        </span>
    </div>

    <div class="space-y-2.5">
        @forelse($habits as $habit)
            @php
                $isDone = in_array($habit->id, $completedHabitIds, true);
            @endphp
            <button 
                type="button"
                wire:click="toggleHabit({{ $habit->id }})"
                class="w-full flex items-center justify-between p-3.5 rounded-lg border transition text-left {{ $isDone ? 'border-tactical-steel/40 bg-tactical-steel/10' : 'border-surface-border bg-surface-base hover:bg-surface-hover' }}"
            >
                <div class="flex items-center gap-3">
                    <div class="h-5 w-5 rounded flex items-center justify-center border {{ $isDone ? 'border-tactical-steel bg-tactical-steel text-surface-base' : 'border-surface-border bg-surface-card' }}">
                        @if($isDone)
                            <svg class="h-3.5 w-3.5 stroke-[3]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        @endif
                    </div>
                    <div>
                        <div class="text-sm font-semibold {{ $isDone ? 'text-tactical-steel line-through' : 'text-content-primary' }}">
                            {{ $habit->title }}
                        </div>
                        <div class="text-[11px] font-mono text-content-muted uppercase">
                            {{ $habit->category }} DRILL
                        </div>
                    </div>
                </div>

                <span class="text-xs font-mono text-content-muted">
                    {{ $isDone ? '+MOMENTUM' : 'EXECUTE' }}
                </span>
            </button>
        @empty
            <p class="text-xs font-mono text-content-muted">No keystone habits registered.</p>
        @endforelse
    </div>
</div>