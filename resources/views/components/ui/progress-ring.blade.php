@props([
    'percentage' => 0,
    'size' => 64,
    'stroke' => 4,
    'color' => 'teal',
])

@php
$radius = ($size - $stroke) / 2;
$circumference = 2 * pi() * $radius;
$offset = $circumference - ($percentage / 100) * $circumference;
$strokeColor = $color === 'copper' ? '#D08A5B' : '#4FB3A9';
@endphp

<div class="relative inline-flex items-center justify-center" style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="transform -rotate-90" width="{{ $size }}" height="{{ $size }}">
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" stroke="#232938" stroke-width="{{ $stroke }}" fill="none" />
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" stroke="{{ $strokeColor }}" stroke-width="{{ $stroke }}" stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $offset }}" stroke-linecap="round" fill="none" class="transition-all duration-500" />
    </svg>
    <span class="absolute text-xs font-mono font-medium text-text-primary tabular-nums">{{ $percentage }}%</span>
</div>