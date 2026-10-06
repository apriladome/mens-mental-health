<div class="max-w-xl mx-auto py-8 text-center" x-data="{
    pattern: 'box',
    phase: 'Inhale',
    secondsLeft: 4,
    timer: null,
    running: false,
    start() {
        this.running = true;
        this.runCycle();
    },
    runCycle() {
        if (!this.running) return;
        let phases = this.pattern === 'box' 
            ? [{ name: 'Inhale', duration: 4 }, { name: 'Hold', duration: 4 }, { name: 'Exhale', duration: 4 }, { name: 'Hold', duration: 4 }]
            : [{ name: 'Deep Inhale', duration: 3 }, { name: 'Top-up Inhale', duration: 1 }, { name: 'Extended Exhale', duration: 6 }];
        
        let index = 0;
        let step = () => {
            if (!this.running) return;
            this.phase = phases[index].name;
            this.secondsLeft = phases[index].duration;
            let tick = setInterval(() => {
                this.secondsLeft--;
                if (this.secondsLeft <= 0) {
                    clearInterval(tick);
                    index = (index + 1) % phases.length;
                    step();
                }
            }, 1000);
        };
        step();
    },
    stop() {
        this.running = false;
        this.phase = 'Ready';
        this.secondsLeft = 4;
    }
}">
    <x-ui.section-header 
        align="center"
        overline="Somatic Reset Drill"
        title="Nervous System Regulation"
        description="Slow respiration mechanically stimulates the vagus nerve, reducing heart rate and autonomic arousal."
    />

    <div class="inline-flex rounded-xl bg-surface border border-border p-1 mb-10">
        <button 
            type="button" 
            class="px-4 py-2 rounded-lg text-xs font-mono transition-colors"
            :class="pattern === 'box' ? 'bg-surface-raised text-teal-400 border border-teal-500/30' : 'text-text-secondary'"
            @click="pattern = 'box'; stop()"
        >
            Box (4-4-4-4)
        </button>
        <button 
            type="button" 
            class="px-4 py-2 rounded-lg text-xs font-mono transition-colors"
            :class="pattern === 'sigh' ? 'bg-surface-raised text-teal-400 border border-teal-500/30' : 'text-text-secondary'"
            @click="pattern = 'sigh'; stop()"
        >
            Physiological Sigh
        </button>
    </div>

    <div class="relative w-64 h-64 mx-auto my-8 flex items-center justify-center">
        <div 
            class="absolute inset-0 rounded-full border-2 border-teal-400/30 shadow-teal-glow transition-all duration-1000"
            :class="{
                'scale-110 border-teal-400': phase.includes('Inhale'),
                'scale-105 border-copper-400': phase === 'Hold',
                'scale-90 border-teal-600': phase.includes('Exhale'),
            }"
        ></div>

        <div class="relative z-10">
            <div class="font-serif text-2xl font-semibold text-text-primary" x-text="phase">Ready</div>
            <div class="font-mono text-3xl text-teal-400 font-semibold mt-1 tabular-nums" x-text="secondsLeft + 's'">4s</div>
        </div>
    </div>

    <div class="mt-8 flex justify-center gap-4">
        <template x-if="!running">
            <x-ui.button variant="primary" size="lg" icon="wind" @click="start()">
                Begin Drill
            </x-ui.button>
        </template>
        <template x-if="running">
            <x-ui.button variant="secondary" size="lg" icon="pause" @click="stop()">
                End Drill & Log
            </x-ui.button>
        </template>
    </div>
</div>