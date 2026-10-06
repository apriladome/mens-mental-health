@props([
    'name' => 'User',
    'size' => 'md',
])

@php
$initials = collect(explode(' ', $name))->map(fn($part) => substr($part, 0, 1))->take(2)->implode('');
if (empty($initials)) {
    $initials = substr($name, 0, 2);
}
$initials = strtoupper($initials);

$sizes = [
    'sm' => 'w-8 h-8 text-xs',
    'md' => 'w-10 h-10 text-sm',
    'lg' => 'w-12 h-12 text-base',
][$size] ?? 'w-10 h-10 text-sm';
@endphp

<div {{ $attributes->merge(['class' => "{$sizes} rounded-xl bg-surface-raised border border-border-strong text-text-primary flex items-center justify-center font-mono font-medium select-none shadow-sm flex-shrink-0"]) }}>
    <span>{{ $initials }}</span>
</div>