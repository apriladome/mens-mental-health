@props([
    'title',
    'open' => false,
])

<div class="rounded-xl bg-surface border border-border p-5 cursor-pointer" x-data="{ isOpen: {{ $open ? 'true' : 'false' }} }" @click="isOpen = !isOpen">
    <div class="flex items-center justify-between font-serif font-medium text-text-primary text-base">
        <span>{{ $title }}</span>
        <x-icon name="chevron-down" size="18" class="text-text-muted transition-transform duration-200" ::class="isOpen ? 'rotate-180' : ''" />
    </div>
    <div x-show="isOpen" x-collapse class="mt-3 text-sm text-text-secondary leading-relaxed pt-3 border-t border-border">
        {{ $slot }}
    </div>
</div>