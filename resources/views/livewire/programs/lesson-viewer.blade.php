<div class="mx-auto max-w-3xl py-8 px-4">
    <!-- Breadcrumbs -->
    <div class="flex items-center gap-2 text-xs font-mono text-content-muted mb-4">
        <a href="{{ route('programs.index') }}" wire:navigate class="hover:text-content-primary">PROTOCOLS</a>
        <span>/</span>
        <span>{{ $lesson->module->program->title }}</span>
        <span>/</span>
        <span class="text-tactical-steel uppercase">{{ $lesson->module->title }}</span>
    </div>

    <!-- Lesson Header -->
    <div class="border-b border-surface-border pb-6 mb-6">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-content-primary">
            {{ $lesson->title }}
        </h1>
        <div class="mt-2 flex items-center gap-4 text-xs font-mono text-content-muted">
            <span>⏱ {{ $lesson->reading_time_minutes }} MIN DRILL</span>
            <span>•</span>
            <span>DISCRETE EXECUTION MANUAL</span>
        </div>
    </div>

    <!-- Commute Audio Mode Player -->
    <x-content.audio-player :src="$lesson->audio_media_url" :title="$lesson->title" />

    <!-- Lesson Body Content -->
    <div class="rounded-xl border border-surface-border bg-surface-card p-6 sm:p-8 shadow-xl text-content-primary text-sm sm:text-base leading-relaxed space-y-4">
        <div class="whitespace-pre-line font-sans">
            {{ $lesson->body_content }}
        </div>

        <!-- Embedded Interactive Drill (e.g. Box Breathing) -->
        @if($lesson->interactive_tool_type === 'box_breathing')
            <div class="mt-8 border-t border-surface-border pt-6">
                <div class="text-xs font-mono text-tactical-steel mb-4">⚡ PRACTICAL DRILL EMBEDDED: EXECUTE NOW</div>
                <livewire:tools.breathing-engine />
            </div>
        @endif
    </div>

    <!-- Advance Button Footer -->
    <div class="mt-8 flex items-center justify-between border-t border-surface-border pt-6">
        <a 
            href="{{ route('programs.index') }}" 
            wire:navigate
            class="text-xs font-mono text-content-secondary hover:text-content-primary"
        >
            ← Return to Protocol Index
        </a>

        <button 
            type="button"
            wire:click="completeAndAdvance"
            class="rounded-lg bg-tactical-steel px-6 py-2.5 text-xs font-mono font-bold text-surface-base hover:bg-sky-300 transition shadow-lg"
        >
            Mark Drill Complete & Advance ➔
        </button>
    </div>
</div>