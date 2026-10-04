@php
    $user = auth()->user();
    $handle = $user?->profile?->public_handle ?? 'Guest_Session';
    $isGuest = $user ? $user->auth_type === 'guest' : true;
@endphp

<header class="sticky top-0 z-40 w-full border-b border-surface-border bg-surface-base/95 backdrop-blur-md">
    <div class="mx-auto flex h-14 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <!-- Brand & Tactical Nav Links -->
        <div class="flex items-center gap-6">
            <a href="/" class="flex items-center gap-2">
                <div class="flex h-8 w-8 items-center justify-center rounded bg-surface-card border border-surface-border text-tactical-steel font-mono font-bold text-sm">
                    <span x-show="!stealth">MMH</span>
                    <span x-show="stealth" x-cloak>SYS</span>
                </div>
                <span class="font-semibold tracking-wide text-content-primary text-sm sm:text-base font-mono">
                    <span x-show="!stealth">OPS://RESILIENCE</span>
                    <span x-show="stealth" x-cloak>TASK_MONITOR_v2</span>
                </span>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-4 text-xs font-mono">
                <!-- 1. Daily Readiness / Member Dashboard -->
                <a href="/dashboard" wire:navigate class="text-content-secondary hover:text-content-primary transition">
                    <span x-show="!stealth">READINESS</span>
                    <span x-show="stealth" x-cloak>CAPACITY</span>
                </a>

                <!-- 2. Box Breathing & Somatic Down-Regulation -->
                <a href="/tools/breathing" wire:navigate class="text-content-secondary hover:text-content-primary transition">
                    <span x-show="!stealth">REGULATION</span>
                    <span x-show="stealth" x-cloak>EXECUTION</span>
                </a>

                <!-- 3. Field Protocols / Modular Courses -->
             <a href="/programs" wire:navigate class="text-content-secondary hover:text-content-primary transition">
               <span x-show="!stealth">FIELD PROTOCOLS</span>
              <span x-show="stealth" x-cloak>PROCESSES</span>
                </a>

                <!-- 4. Pseudonymous Peer Squads -->
                <a href="/squads" wire:navigate class="text-content-secondary hover:text-content-primary transition">
                    <span x-show="!stealth">PEER SQUADS</span>
                    <span x-show="stealth" x-cloak>CHANNELS</span>
                </a>

                <a href="/directory" wire:navigate class="text-content-secondary hover:text-content-primary transition">
    <span x-show="!stealth">CLINICIANS</span>
    <span x-show="stealth" x-cloak>SPECIALISTS</span>
</a>
            </nav>
        </div>

        <!-- Right Side: User Handle Badge + Safety Fixtures -->
        <div class="flex items-center gap-3">
            <!-- Active Identity Indicator -->
            <div class="hidden sm:flex items-center gap-2 rounded border border-surface-border bg-surface-card px-2.5 py-1 text-xs font-mono text-content-secondary">
                <span class="h-1.5 w-1.5 rounded-full {{ $isGuest ? 'bg-tactical-amber' : 'bg-tactical-success' }}"></span>
                <span>{{ $handle }}</span>
                @if($isGuest)
                    <span class="text-[10px] text-content-muted font-sans bg-surface-hover px-1 rounded">GUEST</span>
                @endif
            </div>

            <!-- Stealth Toggle Component -->
            <x-safety.stealth-toggle />

            <!-- Quick Escape Panic Button -->
            <x-safety.quick-exit-button />
        </div>
    </div>
</header>