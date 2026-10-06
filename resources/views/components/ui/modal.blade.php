@props([
    'name',
    'title' => null,
    'maxWidth' => 'md',
])

@php
$maxWidths = [
    'sm' => 'max-w-sm',
    'md' => 'max-w-md',
    'lg' => 'max-w-lg',
    'xl' => 'max-w-xl',
    '2xl' => 'max-w-2xl',
][$maxWidth] ?? 'max-w-md';
@endphp

<div 
    x-data="{ show: false }" 
    x-show="show" 
    x-on:open-modal.window="if ($event.detail === '{{ $name }}') show = true"
    x-on:close-modal.window="if ($event.detail === '{{ $name }}') show = false"
    x-on:keydown.escape.window="show = false"
    style="display: none;"
    class="fixed inset-0 z-50 overflow-y-auto bg-ink-950/80 backdrop-blur-md flex items-center justify-center p-4"
>
    <div 
        x-show="show" 
        x-transition:enter="ease-out duration-200" 
        x-transition:enter-start="opacity-0 scale-95" 
        x-transition:enter-end="opacity-100 scale-100" 
        x-transition:leave="ease-in duration-150" 
        x-transition:leave-start="opacity-100 scale-100" 
        x-transition:leave-end="opacity-0 scale-95"
        class="w-full {{ $maxWidths }} rounded-2xl bg-surface-raised border border-border-strong p-6 shadow-2xl relative"
        @click.away="show = false"
    >
        @if($title)
            <div class="flex items-center justify-between pb-4 border-b border-border mb-5">
                <h3 class="font-serif text-lg font-semibold text-text-primary">{{ $title }}</h3>
                <button type="button" @click="show = false" class="text-text-muted hover:text-text-primary">
                    <x-icon name="x" size="18" />
                </button>
            </div>
        @endif

        {{ $slot }}
    </div>
</div>