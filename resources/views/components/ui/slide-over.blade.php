@props([
    'name',
    'title' => null,
])

<div 
    x-data="{ open: false }" 
    x-show="open" 
    x-on:open-slideover.window="if ($event.detail === '{{ $name }}') open = true"
    x-on:close-slideover.window="if ($event.detail === '{{ $name }}') open = false"
    x-on:keydown.escape.window="open = false"
    style="display: none;"
    class="fixed inset-0 z-50 overflow-hidden bg-ink-950/70 backdrop-blur-sm flex justify-end"
>
    <div 
        x-show="open"
        x-transition:enter="transform transition ease-in-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="w-full max-w-md bg-surface-raised border-l border-border h-full p-6 overflow-y-auto shadow-2xl flex flex-col justify-between"
        @click.away="open = false"
    >
        <div>
            @if($title)
                <div class="flex items-center justify-between pb-4 border-b border-border mb-6">
                    <h3 class="font-serif text-xl font-semibold text-text-primary">{{ $title }}</h3>
                    <button type="button" @click="open = false" class="text-text-muted hover:text-text-primary">
                        <x-icon name="x" size="20" />
                    </button>
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>
</div>