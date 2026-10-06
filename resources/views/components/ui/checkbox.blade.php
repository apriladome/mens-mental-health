@props([
    'label' => null,
    'checked' => false,
])

<label class="inline-flex items-center gap-3 cursor-pointer select-none">
    <input 
        type="checkbox" 
        {{ $checked ? 'checked' : '' }}
        {{ $attributes->merge(['class' => 'w-5 h-5 rounded-lg bg-surface-raised border border-border-strong text-teal-500 focus:ring-teal-400 focus:ring-offset-canvas focus:ring-2 cursor-pointer transition-colors duration-150']) }}
    />
    @if($label)
        <span class="text-sm text-text-secondary">{{ $label }}</span>
    @else
        {{ $slot }}
    @endif
</label>