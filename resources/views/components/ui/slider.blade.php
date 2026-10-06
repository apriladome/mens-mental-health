@props([
    'label' => null,
    'name' => null,
    'min' => 1,
    'max' => 10,
    'step' => 1,
    'value' => 5,
    'color' => 'teal', // teal, copper
])

@php
$accentClass = $color === 'copper' ? 'accent-copper-500' : 'accent-teal-500';
@endphp

<div class="space-y-2" x-data="{ val: {{ $value }} }">
    <div class="flex items-center justify-between">
        @if($label)
            <label class="text-xs font-mono uppercase tracking-wider text-text-muted">{{ $label }}</label>
        @endif
        <span class="text-xs font-mono font-medium {{ $color === 'copper' ? 'text-copper-400' : 'text-teal-400' }} tabular-nums" x-text="val + ' / {{ $max }}'">
            {{ $value }} / {{ $max }}
        </span>
    </div>

    <input 
        type="range" 
        min="{{ $min }}" 
        max="{{ $max }}" 
        step="{{ $step }}" 
        x-model="val" 
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => "w-full h-2 rounded-lg bg-surface border border-border-strong appearance-none cursor-pointer {$accentClass}"]) }}
    />
</div>