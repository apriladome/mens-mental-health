@props([
    'label' => null,
    'name' => null,
    'rows' => 4,
    'error' => null,
    'hint' => null,
])

<div class="space-y-1.5">
    @if($label)
        <label for="{{ $name }}" class="block text-xs font-mono uppercase tracking-wider text-text-muted">
            {{ $label }}
        </label>
    @endif

    <textarea 
        id="{{ $name }}" 
        name="{{ $name }}" 
        rows="{{ $rows }}"
        {{ $attributes->merge(['class' => 'w-full p-4 rounded-xl bg-surface-raised border border-border-strong text-text-primary text-sm focus:border-teal-400 focus:ring-1 focus:ring-teal-400 placeholder:text-text-muted/60 transition-colors duration-150 leading-relaxed']) }}
    >{{ $slot }}</textarea>

    @if($hint)
        <p class="text-[11px] text-text-muted font-mono">{{ $hint }}</p>
    @endif

    @if($error)
        <p class="text-xs text-brick font-mono mt-1">{{ $error }}</p>
    @endif
</div>