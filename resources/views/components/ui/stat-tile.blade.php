@props([
    'label',
    'value',
    'subline' => null,
    'icon' => null,
    'color' => 'teal',
])

<div class="p-5 rounded-2xl bg-surface border border-border shadow-card-glow relative overflow-hidden">
    <div class="flex items-center justify-between text-xs font-mono uppercase tracking-wider text-text-muted mb-2">
        <span>{{ $label }}</span>
        @if($icon)
            <x-icon :name="$icon" size="16" class="{{ $color === 'copper' ? 'text-copper-400' : 'text-teal-400' }}" />
        @endif
    </div>

    <div class="font-serif text-2xl lg:text-3xl font-semibold text-text-primary tabular-nums tracking-tight">
        {{ $value }}
    </div>

    @if($subline)
        <p class="text-xs text-text-secondary mt-1">{{ $subline }}</p>
    @endif
</div>