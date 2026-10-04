<div class="mx-auto max-w-xl py-8 px-4">
    <!-- Header & Mode Selector -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-1.5 rounded-full border border-surface-border bg-surface-card px-3 py-1 text-xs font-mono text-tactical-steel mb-3">
            <span class="h-1.5 w-1.5 rounded-full bg-tactical-steel animate-ping"></span>
            <span>AUTONOMIC DOWN-REGULATION</span>
        </div>
        <h1 class="text-3xl font-extrabold text-content-primary">Tactical Respiration Engine</h1>
        <p class="mt-2 text-sm text-content-secondary max-w-md mx-auto">
            Directly engages the vagus nerve to slow heart rate, drop blood pressure, and neutralize sympathetic fight-or-flight arousal.
        </p>

        <!-- Mode Toggles -->
        <div class="mt-6 inline-flex rounded-lg border border-surface-border bg-surface-base p-1">
            <button 
                type="button"
                wire:click="setMode('box')"
                class="px-4 py-2 text-xs font-mono font-semibold rounded-md transition {{ $mode === 'box' ? 'bg-surface-card text-tactical-steel border border-surface-border shadow-sm' : 'text-content-secondary hover:text-content-primary' }}"
            >
                BOX BREATHING (4-4-4-4)
            </button>
            <button 
                type="button"
                wire:click="setMode('sigh')"
                class="px-4 py-2 text-xs font-mono font-semibold rounded-md transition {{ $mode === 'sigh' ? 'bg-surface-card text-tactical-amber border border-surface-border shadow-sm' : 'text-content-secondary hover:text-content-primary' }}"
            >
                PHYSIOLOGICAL SIGH
            </button>
        </div>
    </div>

    <!-- Active Breathing Engine Card (Alpine.js State Machine) -->
    <div 
        x-data="{
            mode: @entangle('mode'),
            isRunning: false,
            currentPhase: 'READY',
            phaseTimer: 4,
            completedCycles: 0,
            targetCycles: @entangle('targetCycles'),
            interval: null,
            scaleClass: 'scale-75 opacity-40',

            start() {
                this.isRunning = true;
                this.completedCycles = 0;
                this.runLoop();
            },

            stop() {
                this.isRunning = false;
                clearInterval(this.interval);
                this.currentPhase = 'PAUSED';
                this.scaleClass = 'scale-75 opacity-40';
            },

            reset() {
                this.stop();
                this.currentPhase = 'READY';
                this.completedCycles = 0;
            },

            runLoop() {
                if (this.mode === 'box') {
                    this.executeBoxCycle();
                } else {
                    this.executeSighCycle();
                }
            },

            executeBoxCycle() {
                if (!this.isRunning) return;

                // Phase 1: INHALE (4s)
                this.currentPhase = 'INHALE';
                this.phaseTimer = 4;
                this.scaleClass = 'scale-125 opacity-100 border-tactical-steel text-tactical-steel shadow-[0_0_50px_rgba(56,189,248,0.25)]';
                
                this.countdown(4, () => {
                    if (!this.isRunning) return;
                    // Phase 2: HOLD (4s)
                    this.currentPhase = 'HOLD';
                    this.scaleClass = 'scale-125 opacity-90 border-tactical-steel text-tactical-steel';
                    
                    this.countdown(4, () => {
                        if (!this.isRunning) return;
                        // Phase 3: EXHALE (4s)
                        this.currentPhase = 'EXHALE';
                        this.scaleClass = 'scale-75 opacity-40 border-surface-border text-content-muted';
                        
                        this.countdown(4, () => {
                            if (!this.isRunning) return;
                            // Phase 4: HOLD (4s)
                            this.currentPhase = 'HOLD EMPTY';
                            this.scaleClass = 'scale-75 opacity-30 border-surface-border text-content-muted';

                            this.countdown(4, () => {
                                if (!this.isRunning) return;
                                this.completedCycles++;
                                if (this.completedCycles >= this.targetCycles) {
                                    this.finishSession();
                                } else {
                                    this.executeBoxCycle();
                                }
                            });
                        });
                    });
                });
            },

            executeSighCycle() {
                if (!this.isRunning) return;

                // Phase 1: DEEP INHALE (3s)
                this.currentPhase = 'DEEP INHALE';
                this.scaleClass = 'scale-110 opacity-90 border-tactical-amber text-tactical-amber';
                
                this.countdown(3, () => {
                    if (!this.isRunning) return;
                    // Phase 2: TOP-UP INHALE (1s)
                    this.currentPhase = 'TOP-UP INHALE';
                    this.scaleClass = 'scale-125 opacity-100 border-tactical-amber text-tactical-amber shadow-[0_0_50px_rgba(245,158,11,0.25)]';

                    this.countdown(1, () => {
                        if (!this.isRunning) return;
                        // Phase 3: SLOW EXTENDED EXHALE (6s)
                        this.currentPhase = 'LONG EXHALE';
                        this.scaleClass = 'scale-75 opacity-40 border-surface-border text-content-muted';

                        this.countdown(6, () => {
                            if (!this.isRunning) return;
                            this.completedCycles++;
                            if (this.completedCycles >= this.targetCycles) {
                                this.finishSession();
                            } else {
                                this.executeSighCycle();
                            }
                        });
                    });
                });
            },

            countdown(seconds, onComplete) {
                this.phaseTimer = seconds;
                clearInterval(this.interval);
                this.interval = setInterval(() => {
                    this.phaseTimer--;
                    if (this.phaseTimer <= 0) {
                        clearInterval(this.interval);
                        onComplete();
                    }
                }, 1000);
            },

            finishSession() {
                this.isRunning = false;
                clearInterval(this.interval);
                this.currentPhase = 'COMPLETE';
                this.scaleClass = 'scale-100 opacity-100 border-tactical-success text-tactical-success';
                $wire.logSessionCompletion();
            }
        }"
        class="rounded-xl border border-surface-border bg-surface-card/60 backdrop-blur-md p-8 sm:p-12 shadow-2xl text-center"
    >
        <!-- The Visual Breathing Pacer Sphere -->
        <div class="relative h-64 w-64 mx-auto flex items-center justify-center my-6">
            <!-- Ambient Ring Outer Glow -->
            <div 
                class="absolute inset-0 rounded-full border border-surface-border transition-all duration-1000 ease-in-out"
                :class="scaleClass"
            ></div>

            <!-- Inner Circle Core -->
            <div 
                class="relative h-44 w-44 rounded-full border-2 bg-surface-base/80 backdrop-blur-sm flex flex-col items-center justify-center transition-all duration-1000 ease-in-out select-none shadow-inner"
                :class="scaleClass"
            >
                <span class="text-xs font-mono font-bold tracking-widest text-content-muted" x-text="currentPhase"></span>
                <span class="text-4xl font-extrabold font-mono mt-1" x-text="isRunning ? phaseTimer : (completedCycles >= targetCycles ? '✓' : '--')"></span>
            </div>
        </div>

        <!-- Cycle Status & Instruction -->
        <div class="mt-6">
            <div class="text-xs font-mono text-content-muted">
                CYCLE PROGRESS: <span class="text-content-primary font-bold" x-text="completedCycles"></span> / <span x-text="targetCycles"></span>
            </div>
            
            <p class="mt-2 text-xs text-content-secondary max-w-sm mx-auto h-8">
                <span x-show="mode === 'box' && !isRunning">Breathe in through nose (4s), hold (4s), release slowly (4s), hold empty (4s).</span>
                <span x-show="mode === 'sigh' && !isRunning">Two sharp inhales through nose, followed by one long, slow release through mouth.</span>
                <span x-show="isRunning && currentPhase.includes('INHALE')" class="text-tactical-steel">Expand diaphragm. Fill lower abdomen first, then chest.</span>
                <span x-show="isRunning && currentPhase.includes('HOLD')" class="text-content-muted">Maintain soft throat. Avoid tension in jaw or neck.</span>
                <span x-show="isRunning && currentPhase.includes('EXHALE')" class="text-tactical-olive">Release tension through shoulders. Slow, steady deflation.</span>
            </p>
        </div>

        <!-- Completion Alert Banner -->
        <div 
            x-show="completedCycles >= targetCycles" 
            x-cloak
            class="mt-6 rounded-lg border border-tactical-success/30 bg-tactical-success/10 p-4 text-xs font-mono text-tactical-success"
        >
            ✓ DRILL COMPLETED: Autonomic baseline reset. Logged to your daily resilience streak.
        </div>

        <!-- Controls -->
        <div class="mt-8 flex items-center justify-center gap-4">
            <button 
                x-show="!isRunning" 
                @click="start()" 
                type="button"
                class="rounded-lg bg-content-primary px-8 py-3 text-sm font-semibold text-surface-base transition hover:bg-white shadow-lg"
            >
                <span x-text="completedCycles >= targetCycles ? 'Run Again' : 'Begin Drill'"></span>
            </button>

            <button 
                x-show="isRunning" 
                @click="stop()" 
                type="button"
                class="rounded-lg border border-surface-border bg-surface-card px-6 py-3 text-sm font-semibold text-content-primary transition hover:bg-surface-hover"
            >
                Pause Drill
            </button>

            <button 
                x-show="isRunning || completedCycles > 0" 
                @click="reset()" 
                type="button"
                class="text-xs font-mono text-content-muted hover:text-content-primary px-3 py-2"
            >
                Reset
            </button>
        </div>
    </div>
</div>