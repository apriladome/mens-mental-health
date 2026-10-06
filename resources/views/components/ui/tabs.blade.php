@props([
    'tabs' => [],
    'default' => null,
])

<div x-data="{ currentTab: '{{ $default ?? (count($tabs) ? array_key_first($tabs) : '') }}' }" class="w-full">
    <div class="flex items-center gap-2 border-b border-border pb-px overflow-x-auto">
        @foreach($tabs as $key => $label)
            <button 
                type="button" 
                @click="currentTab = '{{ $key }}'" 
                :class="currentTab === '{{ $key }}' ? 'border-teal-400 text-teal-300 font-semibold' : 'border-transparent text-text-muted hover:text-text-primary'"
                class="px-4 py-3 border-b-2 text-sm font-mono whitespace-nowrap transition-colors duration-150"
            >
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $slot }}
    </div>
</div>