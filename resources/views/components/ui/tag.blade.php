@props([
    'active' => false,
])

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-3 py-1 rounded-xl text-xs font-mono transition-colors border ' . ($active ? 'bg-teal-900/30 text-teal-300 border-teal-500/40' : 'bg-surface text-text-muted border-border hover:border-border-strong')]) }}>
    {{ $slot }}
</span>