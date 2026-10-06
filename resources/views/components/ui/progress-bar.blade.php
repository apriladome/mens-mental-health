@props([
    'value' => 0,
    'color' => 'teal', // teal, copper
])

<div class="w-full h-2 rounded-full bg-surface-raised border border-border overflow-hidden">
    <div 
        class="h-full rounded-full transition-all duration-300 {{ $color === 'copper' ? 'bg-copper-500' : 'bg-teal-500' }}" 
        style="width: {{ min(100, max(0, $value)) }}%;"
    ></div>
</div>