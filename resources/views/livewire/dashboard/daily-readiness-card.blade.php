<div class="rounded-xl border border-surface-border bg-surface-card p-6 shadow-xl">
    <!-- Header with Momentum Score -->
    <div class="flex items-center justify-between border-b border-surface-border pb-4 mb-6">
        <div>
            <div class="text-xs font-mono text-tactical-steel">DAILY 30-SECOND CHECK-IN</div>
            <h2 class="text-xl font-bold text-content-primary">Readiness & Drive Matrix</h2>
        </div>
        
        <!-- Momentum Capital Pill -->
        <div class="text-right">
            <div class="text-[10px] font-mono text-content-muted">30-DAY MOMENTUM</div>
            <div class="text-lg font-extrabold font-mono text-tactical-steel">
                {{ $momentumStats['momentum_percentage'] ?? 0 }}%
            </div>
        </div>
    </div>

    <!-- 4 Interactive Sliders -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <!-- Energy Slider -->
        <div>
            <div class="flex justify-between text-xs font-mono mb-1.5">
                <span class="text-content-secondary">PHYSICAL ENERGY</span>
                <span class="text-tactical-steel font-bold">{{ $energyLevel }}/10</span>
            </div>
            <input 
                type="range" min="1" max="10" wire:model="energyLevel" wire:change="saveReadiness"
                class="w-full h-1.5 bg-surface-base rounded-lg appearance-none cursor-pointer accent-tactical-steel"
            >
        </div>

        <!-- Irritability Slider -->
        <div>
            <div class="flex justify-between text-xs font-mono mb-1.5">
                <span class="text-content-secondary">IRRITABILITY / FUSE</span>
                <span class="text-tactical-amber font-bold">{{ $irritabilityLevel }}/10</span>
            </div>
            <input 
                type="range" min="1" max="10" wire:model="irritabilityLevel" wire:change="saveReadiness"
                class="w-full h-1.5 bg-surface-base rounded-lg appearance-none cursor-pointer accent-tactical-amber"
            >
        </div>

        <!-- Focus Slider -->
        <div>
            <div class="flex justify-between text-xs font-mono mb-1.5">
                <span class="text-content-secondary">COGNITIVE CLARITY</span>
                <span class="text-tactical-steel font-bold">{{ $focusLevel }}/10</span>
            </div>
            <input 
                type="range" min="1" max="10" wire:model="focusLevel" wire:change="saveReadiness"
                class="w-full h-1.5 bg-surface-base rounded-lg appearance-none cursor-pointer accent-tactical-steel"
            >
        </div>

        <!-- Sleep Quality Slider -->
        <div>
            <div class="flex justify-between text-xs font-mono mb-1.5">
                <span class="text-content-secondary">RESTORATIVE SLEEP</span>
                <span class="text-tactical-olive font-bold">{{ $sleepQuality }}/10</span>
            </div>
            <input 
                type="range" min="1" max="10" wire:model="sleepQuality" wire:change="saveReadiness"
                class="w-full h-1.5 bg-surface-base rounded-lg appearance-none cursor-pointer accent-tactical-olive"
            >
        </div>
    </div>

    <!-- Footer Status -->
    <div class="mt-6 flex items-center justify-between border-t border-surface-border pt-4 text-xs font-mono">
        <span class="text-content-muted">
            CONSECUTIVE DAYS: <span class="text-content-primary font-bold">{{ $momentumStats['consecutive_days'] ?? 0 }}</span> ({{ $momentumStats['grace_days_used'] ?? 0 }}/2 Pauses Used)
        </span>
        <span class="text-tactical-success flex items-center gap-1">
            <span>●</span> {{ $isSaved ? 'Auto-Saved' : 'Slide to update' }}
        </span>
    </div>
</div>