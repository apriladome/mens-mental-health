@props([
    'variant' => 'primary', // primary, secondary, ghost, danger
    'size' => 'md',        // sm, md, lg
    'type' => 'button',
    'icon' => null,
    'iconRight' => null,
])

@php
$base = "inline-flex items-center justify-center font-medium rounded-xl transition-all duration-150 focus-visible:outline-2 focus-visible:outline-teal-400 focus-visible:outline-offset-2 disabled:opacity-50 disabled:cursor-not-allowed select-none";

$sizes = [
    'sm' => 'h-9 px-3.5 text-xs tracking-wider uppercase',
    'md' => 'h-11 px-5 text-sm',
    'lg' => 'h-13 px-7 text-base font-medium',
][$size] ?? 'h-11 px-5 text-sm';

$variants = [
    'primary' => 'bg-copper-500 hover:bg-copper-400 active:bg-copper-600 text-canvas font-semibold shadow-card-glow',
    'secondary' => 'bg-surface border border-border hover:bg-surface-raised hover:border-teal-500/30 text-text-primary',
    'ghost' => 'text-text-secondary hover:text-text-primary hover:bg-surface-raised/60',
    'danger' => 'bg-surface-raised border border-brick/40 text-brick hover:bg-brick hover:text-canvas',
][$variant] ?? 'bg-copper-500 text-canvas font-semibold';
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "{$base} {$sizes} {$variants}"]) }}>
    @if($icon)
        <x-icon :name="$icon" class="mr-2.5" :size="$size === 'sm' ? 16 : 20" />
    @endif

    {{ $slot }}

    @if($iconRight)
        <x-icon :name="$iconRight" class="ml-2.5" :size="$size === 'sm' ? 16 : 20" />
    @endif
</button>