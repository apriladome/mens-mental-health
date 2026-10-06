@php
    $user = auth()->user();
    $handle = $user?->profile?->public_handle ?? 'Guest_Session';
    $isGuest = $user ? $user->auth_type === 'guest' : true;
@endphp

<header class="sticky top-0 z-40 w-full border-b border-surface-border/80 bg-[#0B0D11]/85 backdrop-blur-xl">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <!-- Brand & Main Navigation -->
        <div class="flex items-center gap-8">
            <a href="/" class="flex items-center gap-3 group">
                <!-- Warm Emblem -->
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-surface-card border border-surface-border text-tactical-steel font-mono font-bold text-sm shadow-inner transition group-hover:border-tactical-steel/50">
                    <span x-show="!stealth">RP</span>
                    <span x-show="stealth" x-cloak>SYS</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-bold tracking-tight text-content-primary text-sm sm:text-base leading-none">
                        <span x-show="!stealth">Resilience Project</span>
                        <span x-show="stealth" x-cloak>TASK_MONITOR_v2</span>
                    </span>
                    <span class="text-[10px] text-content-muted font-mono tracking-wider mt-0.5">
                        <span x-show="!stealth">FOR MEN</span>
                        <span x-show="stealth" x-cloak>DEV_SESSION</span>
                    </span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-6 text-xs font-medium tracking-wide">
                <a href="/dashboard" wire:navigate class="text-content-secondary hover:text-content-primary transition py-1">
                    <span x-show="!stealth">Daily Check-in</span>
                    <span x-show="stealth" x-cloak>CAPACITY</span>
                </a>
                <a href="/tools/breathing" wire:navigate class="text-content-secondary hover:text-content-primary transition py-1">
                    <span x-show="!stealth">Breathing Reset</span>
                    <span x-show="stealth" x-cloak>EXECUTION</span>
                </a>
                <a href="/programs" wire:navigate class="text-content-secondary hover:text-content-primary transition py-1">
                    <span x-show="!stealth">Protocols</span>
                    <span x-show="stealth" x-cloak>PROCESSES</span>
                </a>
                <a href="/squads" wire:navigate class="text-content-secondary hover:text-content-primary transition py-1">
                    <span x-show="!stealth">Peer Squads</span>
                    <span x-show="stealth" x-cloak>CHANNELS</span>
                </a>
                <a href="/directory" wire:navigate class="text-content-secondary hover:text-content-primary transition py-1">
                    <span x-show="!stealth">Specialists</span>
                    <span x-show="stealth" x-cloak>DIRECTORY</span>
                </a>
            </nav>
        </div>

        <!-- Right Side: User Handle Badge + Safety Controls -->
        <div class="flex items-center gap-3">
            <!-- Active Identity Indicator -->
            <div class="hidden sm:flex items-center gap-2 rounded-lg border border-surface-border bg-surface-card/60 px-3 py-1.5 text-xs font-mono text-content-secondary">
                <span class="h-2 w-2 rounded-full {{ $isGuest ? 'bg-amber-400' : 'bg-emerald-400' }} animate-pulse"></span>
                <span>{{ $handle }}</span>
                @if($isGuest)
                    <span class="text-[10px] text-content-muted font-sans bg-surface-base px-1.5 py-0.5 rounded border border-surface-border/50">ANONYMOUS</span>
                @endif
            </div>

            <!-- Stealth Mode Toggle -->
            <x-safety.stealth-toggle />

            <!-- Quick Escape Button -->
            <x-safety.quick-exit-button />
        </div>
    </div>
</header>