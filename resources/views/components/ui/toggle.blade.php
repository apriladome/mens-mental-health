@props([
    'label' => null,
    'checked' => false,
])

<label class="inline-flex items-center gap-3 cursor-pointer select-none" x-data="{ state: {{ $checked ? 'true' : 'false' }} }">
    <div class="relative">
        <input type="checkbox" x-model="state" class="sr-only" {{ $attributes }} />
        <div class="w-11 h-6 rounded-full border border-border-strong transition-colors duration-200" :class="state ? 'bg-teal-600 border-teal-500' : 'bg-surface-raised'"></div>
        <div class="dot absolute left-1 top-1 bg-text-primary w-4 h-4 rounded-full transition-transform duration-200" :class="state ? 'translate-x-5 bg-canvas' : ''"></div>
    </div>
    @if($label)
        <span class="text-sm text-text-secondary">{{ $label }}</span>
    @endif
</label>