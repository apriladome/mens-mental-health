@props([
    'variant' => 'neutral', // neutral, teal, copper, moss, brass, brick
    'size' => 'md',        // sm, md
])

@php
$variants = [
    'neutral' => 'bg-surface-raised border-border text-text-secondary',
    'teal' => 'bg-teal-900/40 border-teal-500/30 text-teal-400',
    'copper' => 'bg-copper-900/40 border-copper-500/30 text-copper-400',
    'moss' => 'bg-moss/10 border-moss/30 text-moss',
    'brass' => 'bg-brass/10 border-brass/30 text-brass',
    'brick' => 'bg-brick/10 border-brick/30 text-brick',
][$variant] ?? 'bg-surface-raised border-border text-text-secondary';

$sizes = [
    'sm' => 'px-2 py-0.5 text-[10px]',
    'md' => 'px-2.5 py-1 text-xs',
][$size] ?? 'px-2.5 py-1 text-xs';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-lg border font-mono font-medium tracking-wide uppercase select-none {$variants} {$sizes}"]) }}>
    {{ $slot }}
</span>