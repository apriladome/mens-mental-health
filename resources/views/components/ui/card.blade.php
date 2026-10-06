@props([
    'variant' => 'default', // default, raised, interactive
    'class' => '',
])

@php
$variants = [
    'default' => 'bg-surface border border-border shadow-card-glow',
    'raised' => 'bg-surface-raised border border-border-strong shadow-card-glow',
    'interactive' => 'bg-surface border border-border hover:bg-surface-raised hover:border-teal-500/40 transition-all duration-200 cursor-pointer shadow-card-glow',
][$variant] ?? 'bg-surface border border-border shadow-card-glow';
@endphp

<div {{ $attributes->merge(['class' => "rounded-2xl p-6 relative overflow-hidden {$variants} {$class}"]) }}>
    <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-teal-400/20 to-transparent pointer-events-none" aria-hidden="true"></div>
    {{ $slot }}
</div>