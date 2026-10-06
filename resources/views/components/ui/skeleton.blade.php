@props([
    'class' => 'h-4 w-full',
])

<div {{ $attributes->merge(['class' => "animate-pulse rounded-lg bg-surface-raised border border-border/40 {$class}"]) }}></div>