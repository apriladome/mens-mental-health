@props([
    'name',
    'size' => 20,
    'class' => '',
])

@php
$sizes = [
    14 => 'w-3.5 h-3.5',
    16 => 'w-4 h-4',
    18 => 'w-4.5 h-4.5',
    20 => 'w-5 h-5',
    22 => 'w-5.5 h-5.5',
    24 => 'w-6 h-6',
    32 => 'w-8 h-8',
];
$sizeClass = $sizes[$size] ?? 'w-5 h-5';
@endphp

<svg 
    xmlns="http://www.w3.org/2000/svg" 
    viewBox="0 0 24 24" 
    fill="none" 
    stroke="currentColor" 
    stroke-width="1.5" 
    stroke-linecap="round" 
    stroke-linejoin="round" 
    {{ $attributes->merge(['class' => "{$sizeClass} inline-block flex-shrink-0 {$class}"]) }}
    aria-hidden="true"
>
    @switch($name)
        @case('wind')
            <path d="M17.7 7.7a2.5 2.5 0 1 1 1.8 4.3H2" />
            <path d="M9.6 4.6A2 2 0 1 1 11 8H2" />
            <path d="M12.6 19.4A2 2 0 1 0 14 16H2" />
            @break

        @case('moon')
            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z" />
            @break

        @case('sunrise')
            <path d="M12 2v6" />
            <path d="m4.93 10.93 1.41 1.41" />
            <path d="M2 18h2" />
            <path d="M20 18h2" />
            <path d="m19.07 10.93-1.41 1.41" />
            <path d="M22 22H2" />
            <path d="m8 6 4-4 4 4" />
            <path d="M16 18a4 4 0 0 0-8 0" />
            @break

        @case('activity')
        @case('heart-pulse')
            <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
            @break

        @case('shield-check')
            <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
            <path d="m9 12 2 2 4-4" />
            @break

        @case('lock')
            <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
            @break

        @case('anchor')
            <circle cx="12" cy="5" r="3" />
            <line x1="12" x2="12" y1="22" y2="8" />
            <path d="M5 12H2a10 10 0 0 0 20 0h-3" />
            @break

        @case('compass')
            <circle cx="12" cy="12" r="10" />
            <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76" />
            @break

        @case('users')
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
            <circle cx="9" cy="7" r="4" />
            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            @break

        @case('stethoscope')
            <path d="M11 2v2" />
            <path d="M5 2v2" />
            <path d="M5 3H4a2 2 0 0 0-2 2v4a6 6 0 0 0 12 0V5a2 2 0 0 0-2-2h-1" />
            <path d="M8 15a6 6 0 0 0 12 0v-3" />
            <circle cx="20" cy="10" r="2" />
            @break

        @case('phone')
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
            @break

        @case('message-square')
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
            @break

        @case('log-out')
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
            <polyline points="16 17 21 12 16 7" />
            <line x1="21" x2="9" y1="12" y2="12" />
            @break

        @case('eye-off')
            <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24" />
            <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68" />
            <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61" />
            <line x1="2" x2="22" y1="2" y2="22" />
            @break

        @case('dice-5')
            <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
            <path d="M16 8h.01" />
            <path d="M8 8h.01" />
            <path d="M8 16h.01" />
            <path d="M16 16h.01" />
            <path d="M12 12h.01" />
            @break

        @case('flame')
            <path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z" />
            @break

        @case('mountain')
            <path d="m8 3 4 8 5-5 5 15H2L8 3z" />
            @break

        @case('footprints')
            <path d="M4 16v-2.38C4 11.5 2.97 10.5 3 8c.03-2.72 1.49-6 4.5-6C9.37 2 10 3.8 10 5.5c0 3.11-2 5.67-2 8.5v2" />
            <path d="M20 20v-2.38c0-2.12 1.03-3.12 1-5.62-.03-2.72-1.49-6-4.5-6C14.63 6 14 7.8 14 9.5c0 3.11 2 5.67 2 8.5v2" />
            @break

        @case('check-circle')
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
            <polyline points="22 4 12 14.01 9 11.01" />
            @break

        @case('chevron-right')
            <path d="m9 18 6-6-6-6" />
            @break

        @case('chevron-down')
            <path d="m6 9 6 6 6-6" />
            @break

        @case('arrow-right')
            <line x1="5" x2="19" y1="12" y2="12" />
            <polyline points="12 5 19 12 12 19" />
            @break

        @case('arrow-left')
            <line x1="19" x2="5" y1="12" y2="12" />
            <polyline points="12 19 5 12 12 5" />
            @break

        @case('book-open')
            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
            @break

        @case('headphones')
            <path d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3" />
            @break

        @case('calendar')
            <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
            <line x1="16" x2="16" y1="2" y2="6" />
            <line x1="8" x2="8" y1="2" y2="6" />
            <line x1="3" x2="21" y1="10" y2="10" />
            @break

        @case('clock')
            <circle cx="12" cy="12" r="10" />
            <polyline points="12 6 12 12 16 14" />
            @break

        @case('alert-triangle')
            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
            <line x1="12" x2="12" y1="9" y2="13" />
            <line x1="12" x2="12.01" y1="17" y2="17" />
            @break

        @case('play')
            <polygon points="5 3 19 12 5 21 5 3" />
            @break

        @case('pause')
            <rect width="4" height="16" x="6" y="4" />
            <rect width="4" height="16" x="14" y="4" />
            @break

        @case('skip-forward')
            <polygon points="5 4 15 12 5 20 5 4" />
            <line x1="19" x2="19" y1="5" y2="19" />
            @break

        @case('search')
            <circle cx="11" cy="11" r="8" />
            <line x1="21" x2="16.65" y1="21" y2="16.65" />
            @break

        @case('filter')
            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
            @break

        @case('check')
            <polyline points="20 6 9 17 4 12" />
            @break

        @case('x')
            <line x1="18" x2="6" y1="6" y2="18" />
            <line x1="6" x2="18" y1="6" y2="18" />
            @break

        @case('help-circle')
            <circle cx="12" cy="12" r="10" />
            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
            <path d="M12 17h.01" />
            @break

        @case('refresh-cw')
            <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8" />
            <path d="M21 3v5h-5" />
            <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16" />
            <path d="M3 21v-5h5" />
            @break

        @default
            <circle cx="12" cy="12" r="9" />
            <line x1="12" x2="12" y1="8" y2="12" />
            <line x1="12" x2="12.01" y1="16" y2="16" />
    @endswitch
</svg>