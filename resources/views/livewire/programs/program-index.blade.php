<div class="mx-auto max-w-4xl py-8 px-4">
    <!-- Header -->
    <div class="mb-8">
        <div class="text-xs font-mono text-tactical-steel mb-2">FIELD MANUALS & PROTOCOLS</div>
        <h1 class="text-3xl font-extrabold text-content-primary">Operational Resilience Tracks</h1>
        <p class="mt-2 text-sm text-content-secondary max-w-2xl leading-relaxed">
            Multi-day structured tracks combining mechanical neurobiology, cognitive reframing drills, and circadian restoration. Built for execution during daily transit or evening wind-down.
        </p>
    </div>

    <!-- Programs Grid -->
    <div class="space-y-6">
        @forelse($programs as $program)
            @php
                $stats = $progressMap[$program->id] ?? [
                    'completion_percentage' => 0,
                    'completed_lessons_count' => 0,
                    'total_lessons' => 0,
                    'next_lesson' => null,
                    'is_completed' => false,
                ];
                $nextLesson = $stats['next_lesson'];
            @endphp

            <div class="rounded-xl border border-surface-border bg-surface-card p-6 sm:p-8 shadow-xl">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-surface-border pb-6">
                    <div>
                        <div class="inline-flex items-center gap-2 text-xs font-mono text-tactical-amber mb-2">
                            <span>EST. {{ $program->estimated_completion_days }} DAYS</span>
                            <span>•</span>
                            <span class="uppercase">{{ $program->tier_requirement }} TIER</span>
                        </div>
                        <h2 class="text-2xl font-bold text-content-primary">{{ $program->title }}</h2>
                        <p class="mt-2 text-sm text-content-secondary leading-relaxed max-w-xl">
                            {{ $program->summary }}
                        </p>
                    </div>

                    <!-- Progress Dial / Action -->
                    <div class="text-left sm:text-right flex-shrink-0">
                        <div class="text-[11px] font-mono text-content-muted">TRACK COMPLETION</div>
                        <div class="text-2xl font-extrabold font-mono text-tactical-steel mt-0.5">
                            {{ $stats['completion_percentage'] }}%
                        </div>
                        <div class="text-xs font-mono text-content-muted mt-1">
                            {{ $stats['completed_lessons_count'] }}/{{ $stats['total_lessons'] }} DRILLS COMPLETED
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="h-1.5 w-full bg-surface-base rounded-full overflow-hidden border border-surface-border my-6">
                    <div 
                        class="h-full bg-tactical-steel transition-all duration-300"
                        style="width: {{ $stats['completion_percentage'] }}%"
                    ></div>
                </div>

                <!-- Module & Lessons List Preview -->
                <div class="mt-4 space-y-4">
                    @foreach($program->modules as $module)
                        <div class="rounded-lg border border-surface-border bg-surface-base/60 p-4">
                            <div class="text-xs font-mono text-tactical-olive mb-2 uppercase">{{ $module->title }}</div>
                            <div class="space-y-2">
                                @foreach($module->lessons as $lesson)
                                    <div class="flex items-center justify-between text-xs py-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-content-muted font-mono">0{{ $lesson->order }}.</span>
                                            <span class="font-medium text-content-primary">{{ $lesson->title }}</span>
                                        </div>
                                        <div class="flex items-center gap-3 text-content-muted font-mono text-[11px]">
                                            @if($lesson->interactive_tool_type)
                                                <span class="text-tactical-steel">⚡ DRILL ATTACHED</span>
                                            @endif
                                            <span>{{ $lesson->reading_time_minutes }} MIN</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Action Button -->
                <div class="mt-6 flex justify-end">
                    @if($nextLesson)
                        <a 
                            href="{{ route('programs.lesson', ['slug' => $nextLesson->slug]) }}" 
                            wire:navigate
                            class="rounded-lg bg-content-primary px-6 py-2.5 text-xs font-mono font-bold text-surface-base hover:bg-white transition shadow-lg"
                        >
                            {{ $stats['completed_lessons_count'] > 0 ? "Resume: {$nextLesson->title} ➔" : "Begin Protocol ➔" }}
                        </a>
                    @else
                        <span class="text-xs font-mono text-tactical-success flex items-center gap-1.5">
                            ✓ Protocol Fully Completed
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-xs font-mono text-content-muted">No operational programs currently published.</p>
        @endforelse
    </div>
</div>