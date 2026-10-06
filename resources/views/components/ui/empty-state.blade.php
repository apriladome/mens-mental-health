@props([
    'icon' => 'compass',
    'title' => 'Nothing recorded yet',
    'description' => 'Take the first action to begin generating objective data.',
    'actionLabel' => null,
    'actionUrl' => null,
])

<div class="p-10 rounded-2xl bg-surface border border-border text-center max-w-md mx-auto my-6">
    <div class="w-12 h-12 rounded-xl bg-surface-raised border border-border-strong mx-auto flex items-center justify-center text-teal-400 mb-4">
        <x-icon :name="$icon" size="24" />
    </div>

    <h4 class="font-serif text-lg font-medium text-text-primary mb-1">{{ $title }}</h4>
    <p class="text-xs text-text-secondary mb-6 leading-relaxed">{{ $description }}</p>

    @if($actionLabel && $actionUrl)
        <x-ui.button variant="secondary" size="sm" onclick="window.location.href='{{ $actionUrl }}'">
            {{ $actionLabel }}
        </x-ui.button>
    @endif
</div>