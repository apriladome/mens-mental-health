@props([
    'label' => null,
    'name' => null,
    'error' => null,
])

<div class="space-y-1.5">
    @if($label)
        <label for="{{ $name }}" class="block text-xs font-mono uppercase tracking-wider text-text-muted">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        <select 
            id="{{ $name }}" 
            name="{{ $name }}" 
            {{ $attributes->merge(['class' => 'w-full h-11 px-4 pr-10 rounded-xl bg-surface-raised border border-border-strong text-text-primary text-sm focus:border-teal-400 focus:ring-1 focus:ring-teal-400 appearance-none transition-colors duration-150 cursor-pointer']) }}
        >
            {{ $slot }}
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center px-3.5 pointer-events-none text-text-muted">
            <x-icon name="chevron-down" size="16" />
        </div>
    </div>

    @if($error)
        <p class="text-xs text-brick font-mono mt-1">{{ $error }}</p>
    @endif
</div>