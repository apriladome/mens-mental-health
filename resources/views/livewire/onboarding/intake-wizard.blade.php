<div class="mx-auto max-w-2xl py-8 px-4">
    <!-- Progress Indicator -->
    <div class="mb-8">
        <div class="flex items-center justify-between text-xs font-mono text-content-muted mb-2">
            <span>STEP 0{{ $step }} OF 0{{ $totalSteps }}</span>
            <span>{{ match($step) { 1 => 'PRIMARY STRAIN AUDIT', 2 => 'PHYSIOLOGICAL BASELINE', 3 => 'ANONYMOUS HANDLE', default => '' } }}</span>
        </div>
        <div class="h-1.5 w-full bg-surface-card rounded-full overflow-hidden border border-surface-border">
            <div 
                class="h-full bg-tactical-steel transition-all duration-300"
                style="width: {{ ($step / $totalSteps) * 100 }}%"
            ></div>
        </div>
    </div>

    <!-- Container Card -->
    <div class="rounded-xl border border-surface-border bg-surface-card/70 backdrop-blur-sm p-6 sm:p-8 shadow-2xl">
        
        <!-- STEP 1: Energy Leak Vectors -->
        @if($step === 1)
            <div>
                <h2 class="text-2xl font-bold text-content-primary">Where is your pressure leaking most?</h2>
                <p class="mt-2 text-sm text-content-secondary leading-relaxed">
                    Select the vectors currently draining your mental bandwidth. This calibrates your initial daily field drills.
                </p>

                @error('selectedStrains')
                    <div class="mt-3 text-xs font-mono text-tactical-danger">{{ $message }}</div>
                @enderror

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @php
                        $strains = [
                            'work_burnout' => ['title' => 'Executive & Work Burnout', 'desc' => 'Cognitive fatigue, loss of focus, endless demand.'],
                            'sleep_distruption' => ['title' => 'Fragmented Sleep', 'desc' => '3:00 AM racing mind, waking up depleted.'],
                            'anger_irritability' => ['title' => 'Low Fuse & Irritability', 'desc' => 'Snapping at family, physical jaw/neck tension.'],
                            'relationship_divorce' => ['title' => 'Relationship Strain / Divorce', 'desc' => 'Navigating conflict, separation, or custody friction.'],
                            'social_isolation' => ['title' => 'Isolation & Direction', 'desc' => 'Feeling disconnected, lack of purpose, carrying it solo.'],
                            'chronic_pain_stress' => ['title' => 'Physical Pain & Recovery', 'desc' => 'Body breakdown from labor or stress loops.'],
                        ];
                    @endphp

                    @foreach($strains as $key => $strain)
                        <button 
                            type="button"
                            wire:click="toggleStrain('{{ $key }}')"
                            class="text-left p-4 rounded-lg border transition-all {{ in_array($key, $selectedStrains) ? 'border-tactical-steel bg-tactical-steel/10' : 'border-surface-border bg-surface-base/50 hover:border-surface-hover hover:bg-surface-hover/30' }}"
                        >
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold {{ in_array($key, $selectedStrains) ? 'text-tactical-steel' : 'text-content-primary' }}">
                                    {{ $strain['title'] }}
                                </span>
                                @if(in_array($key, $selectedStrains))
                                    <span class="text-tactical-steel">✓</span>
                                @endif
                            </div>
                            <p class="mt-1 text-xs text-content-muted">{{ $strain['desc'] }}</p>
                        </button>
                    @endforeach
                </div>

                <div class="mt-8 flex justify-end">
                    <button 
                        wire:click="nextStep"
                        type="button"
                        class="rounded-lg bg-content-primary px-6 py-2.5 text-sm font-semibold text-surface-base transition hover:bg-white"
                    >
                        Continue to Baseline ➔
                    </button>
                </div>
            </div>
        @endif

        <!-- STEP 2: Somatic Baseline Check-in -->
        @if($step === 2)
            <div>
                <h2 class="text-2xl font-bold text-content-primary">Calibrate Your Baseline</h2>
                <p class="mt-2 text-sm text-content-secondary leading-relaxed">
                    Be candid—your answers are completely private. Rate where your body and mind stand right now.
                </p>

                <div class="mt-6 space-y-6">
                    <!-- Energy Slider -->
                    <div>
                        <div class="flex justify-between text-xs font-mono mb-2">
                            <span class="text-content-secondary">PHYSICAL ENERGY</span>
                            <span class="text-tactical-steel font-bold">{{ $energyLevel }} / 10</span>
                        </div>
                        <input 
                            type="range" min="1" max="10" wire:model.live="energyLevel"
                            class="w-full h-2 bg-surface-border rounded-lg appearance-none cursor-pointer accent-tactical-steel"
                        >
                        <div class="flex justify-between text-[10px] text-content-muted mt-1">
                            <span>Exhausted</span>
                            <span>Fully Charged</span>
                        </div>
                    </div>

                    <!-- Irritability Slider -->
                    <div>
                        <div class="flex justify-between text-xs font-mono mb-2">
                            <span class="text-content-secondary">IRRITABILITY / FUSE LENGTH</span>
                            <span class="text-tactical-amber font-bold">{{ $irritabilityLevel }} / 10</span>
                        </div>
                        <input 
                            type="range" min="1" max="10" wire:model.live="irritabilityLevel"
                            class="w-full h-2 bg-surface-border rounded-lg appearance-none cursor-pointer accent-tactical-amber"
                        >
                        <div class="flex justify-between text-[10px] text-content-muted mt-1">
                            <span>Hair-Trigger Reactive</span>
                            <span>Calm & Composed</span>
                        </div>
                    </div>

                    <!-- Focus Slider -->
                    <div>
                        <div class="flex justify-between text-xs font-mono mb-2">
                            <span class="text-content-secondary">MENTAL FOCUS & DRIVE</span>
                            <span class="text-tactical-steel font-bold">{{ $focusLevel }} / 10</span>
                        </div>
                        <input 
                            type="range" min="1" max="10" wire:model.live="focusLevel"
                            class="w-full h-2 bg-surface-border rounded-lg appearance-none cursor-pointer accent-tactical-steel"
                        >
                        <div class="flex justify-between text-[10px] text-content-muted mt-1">
                            <span>Brain Fog / Paralyzed</span>
                            <span>Sharp & Focused</span>
                        </div>
                    </div>

                    <!-- Sleep Quality Slider -->
                    <div>
                        <div class="flex justify-between text-xs font-mono mb-2">
                            <span class="text-content-secondary">LAST NIGHT'S RESTORATIVE SLEEP</span>
                            <span class="text-tactical-olive font-bold">{{ $sleepQuality }} / 10</span>
                        </div>
                        <input 
                            type="range" min="1" max="10" wire:model.live="sleepQuality"
                            class="w-full h-2 bg-surface-border rounded-lg appearance-none cursor-pointer accent-tactical-olive"
                        >
                        <div class="flex justify-between text-[10px] text-content-muted mt-1">
                            <span>Broken / Racing Mind</span>
                            <span>Deep & Restorative</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-between">
                    <button 
                        wire:click="previousStep"
                        type="button"
                        class="text-xs font-mono text-content-secondary hover:text-content-primary"
                    >
                        ← Back
                    </button>
                    <button 
                        wire:click="nextStep"
                        type="button"
                        class="rounded-lg bg-content-primary px-6 py-2.5 text-sm font-semibold text-surface-base transition hover:bg-white"
                    >
                        Continue to Identity ➔
                    </button>
                </div>
            </div>
        @endif

        <!-- STEP 3: Identity Setup -->
        @if($step === 3)
            <div>
                <h2 class="text-2xl font-bold text-content-primary">Your Tactical Handle</h2>
                <p class="mt-2 text-sm text-content-secondary leading-relaxed">
                    We never display real names. Choose an anonymous identity for community discussions and tracking. You can re-roll or customize this anytime.
                </p>

                <div class="mt-6">
                    <label class="block text-xs font-mono text-content-muted mb-2">PSEUDONYMOUS CALLSIGN</label>
                    <div class="flex items-center gap-3">
                        <input 
                            type="text" 
                            wire:model="publicHandle"
                            class="flex-1 rounded-lg border border-surface-border bg-surface-base px-4 py-2.5 font-mono text-content-primary focus:border-tactical-steel focus:ring-1 focus:ring-tactical-steel"
                        >
                        <button 
                            type="button" 
                            wire:click="generateHandle"
                            class="rounded-lg border border-surface-border bg-surface-hover px-4 py-2.5 text-xs font-mono text-content-secondary hover:text-content-primary transition"
                            title="Generate a random handle"
                        >
                            🎲 Re-Roll
                        </button>
                    </div>
                    @error('publicHandle')
                        <div class="mt-2 text-xs text-tactical-danger font-mono">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-6 rounded-lg border border-surface-border bg-surface-base/60 p-4 text-xs text-content-muted leading-relaxed">
                    🔒 <strong class="text-content-secondary">Air-Gapped Privacy:</strong> You are currently operating in Guest Mode. Your progress will be saved automatically to this browser.
                </div>

                <div class="mt-8 flex items-center justify-between">
                    <button 
                        wire:click="previousStep"
                        type="button"
                        class="text-xs font-mono text-content-secondary hover:text-content-primary"
                    >
                        ← Back
                    </button>
                    <button 
                        wire:click="completeIntake"
                        type="button"
                        class="rounded-lg bg-tactical-steel px-6 py-2.5 text-sm font-semibold text-surface-base transition hover:bg-sky-300"
                    >
                        Lock In Baseline & Enter
                    </button>
                </div>
            </div>
        @endif

    </div>
</div>