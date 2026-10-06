<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Resilience Project') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-canvas text-text-primary min-h-screen flex flex-col antialiased selection:bg-teal-500/25 selection:text-text-primary bg-topographic"
      x-data="{ stealth: localStorage.getItem('mmh_stealth') === 'true' }"
      :class="{ 'theme-stealth': stealth }">

    <!-- UNIVERSAL HEADER -->
    <header class="sticky top-0 z-40 bg-canvas/90 backdrop-blur-md border-b border-border h-16 flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="/dashboard" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-surface-raised border border-border-strong flex items-center justify-center text-teal-400">
                        <x-icon name="compass" size="18" />
                    </div>
                    <span class="font-serif font-semibold tracking-tight text-text-primary stealth-mask-title">Resilience</span>
                </a>

                <nav class="hidden md:flex items-center gap-5 text-sm text-text-secondary">
                    <a href="/dashboard" class="hover:text-text-primary flex items-center gap-1.5"><x-icon name="activity" size="16" /> Dashboard</a>
                    <a href="/tools/breathing" class="hover:text-text-primary flex items-center gap-1.5"><x-icon name="wind" size="16" /> Somatic Tools</a>
                    <a href="/programs" class="hover:text-text-primary flex items-center gap-1.5"><x-icon name="book-open" size="16" /> Protocols</a>
                    <a href="/squads" class="hover:text-text-primary flex items-center gap-1.5"><x-icon name="users" size="16" /> Squads</a>
                    <a href="/directory" class="hover:text-text-primary flex items-center gap-1.5"><x-icon name="stethoscope" size="16" /> Clinicians</a>
                </nav>
            </div>

            <div class="flex items-center gap-3">
                <button 
                    type="button"
                    @click="stealth = !stealth; localStorage.setItem('mmh_stealth', stealth)" 
                    class="h-9 px-3 rounded-lg bg-surface border border-border hover:bg-surface-raised text-text-muted hover:text-teal-400 text-xs font-mono transition-colors flex items-center gap-1.5"
                    title="Toggle Stealth Mode"
                >
                    <x-icon name="eye-off" size="14" />
                    <span class="hidden sm:inline" x-text="stealth ? 'Normal' : 'Stealth'"></span>
                </button>

                <a 
                    href="https://weather.com" 
                    onclick="window.location.replace('https://weather.com'); return false;"
                    class="h-9 px-3 rounded-lg bg-surface border border-border hover:bg-surface-raised text-text-muted hover:text-brick text-xs font-mono transition-colors flex items-center gap-1.5"
                >
                    <x-icon name="log-out" size="14" />
                    <span class="hidden sm:inline">Exit [ESC]</span>
                </a>

                <div class="px-3 py-1 rounded-lg bg-surface-raised border border-border text-xs font-mono text-text-secondary flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-teal-400"></span>
                    <span>{{ auth()->user()?->profile?->public_handle ?? 'Guest' }}</span>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        {{ $slot }}
    </main>

    <nav class="md:hidden sticky bottom-0 z-40 bg-canvas/95 backdrop-blur-md border-t border-border flex items-center justify-around h-16 px-2">
        <a href="/dashboard" class="flex flex-col items-center gap-1 text-[11px] font-mono text-text-secondary hover:text-teal-400">
            <x-icon name="activity" size="18" />
            <span>Audit</span>
        </a>
        <a href="/tools/breathing" class="flex flex-col items-center gap-1 text-[11px] font-mono text-text-secondary hover:text-teal-400">
            <x-icon name="wind" size="18" />
            <span>Reset</span>
        </a>
        <a href="/programs" class="flex flex-col items-center gap-1 text-[11px] font-mono text-text-secondary hover:text-teal-400">
            <x-icon name="book-open" size="18" />
            <span>Tracks</span>
        </a>
        <a href="/squads" class="flex flex-col items-center gap-1 text-[11px] font-mono text-text-secondary hover:text-teal-400">
            <x-icon name="users" size="18" />
            <span>Squads</span>
        </a>
    </nav>

    @livewireScripts
    <script>
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                window.location.replace('https://weather.com');
            }
        });
    </script>
</body>
</html>