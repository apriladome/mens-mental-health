@props([
    'message' => 'Notification recorded',
    'type' => 'neutral', // neutral, success, danger
])

@php
$typeClasses = [
    'neutral' => 'border-border text-text-primary',
    'success' => 'border-moss/40 text-moss',
    'danger' => 'border-brick/40 text-brick',
][$type] ?? 'border-border text-text-primary';
@endphp

<div 
    x-data="{ show: true }" 
    x-show="show" 
    x-init="setTimeout(() => show = false, 4000)"
    x-transition
    class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3 rounded-xl bg-surface-raised border shadow-2xl {{ $typeClasses }}"
>
    <x-icon :name="$type === 'danger' ? 'alert-triangle' : ($type === 'success' ? 'check-circle' : 'info')" size="18" />
    <span class="text-xs font-mono">{{ $message }}</span>
</div>