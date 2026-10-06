<div class="max-w-2xl mx-auto py-10">
    <div class="text-center mb-8">
        <span class="text-xs uppercase font-mono tracking-widest text-teal-400">Tactical Intake</span>
        <h1 class="font-serif text-3xl font-semibold text-text-primary mt-2">Where is your strain concentrated?</h1>
        <p class="text-sm text-text-secondary mt-2">Zero clinical diagnostic labels. Select what is currently draining your daily energy.</p>
    </div>

    <x-ui.card>
        <div class="grid grid-cols-2 gap-4 mb-8">
            <button type="button" class="p-4 rounded-xl border border-border bg-surface-raised hover:border-teal-500/40 text-left transition-colors">
                <x-icon name="flame" class="text-copper-400 mb-2" size="20" />
                <div class="text-sm font-semibold text-text-primary">Executive Burnout</div>
                <div class="text-xs text-text-muted mt-1">Mental overload & exhaustion</div>
            </button>

            <button type="button" class="p-4 rounded-xl border border-border bg-surface-raised hover:border-teal-500/40 text-left transition-colors">
                <x-icon name="moon" class="text-teal-400 mb-2" size="20" />
                <div class="text-sm font-semibold text-text-primary">Sleep Fragmentation</div>
                <div class="text-xs text-text-muted mt-1">Waking up fatigued at 3 AM</div>
            </button>

            <button type="button" class="p-4 rounded-xl border border-border bg-surface-raised hover:border-teal-500/40 text-left transition-colors">
                <x-icon name="mountain" class="text-brass mb-2" size="20" />
                <div class="text-sm font-semibold text-text-primary">Life Transition</div>
                <div class="text-xs text-text-muted mt-1">Divorce or career shift</div>
            </button>

            <button type="button" class="p-4 rounded-xl border border-border bg-surface-raised hover:border-teal-500/40 text-left transition-colors">
                <x-icon name="activity" class="text-dusk-400 mb-2" size="20" />
                <div class="text-sm font-semibold text-text-primary">Physical & Somatic Strain</div>
                <div class="text-xs text-text-muted mt-1">Jaw clenching & back tension</div>
            </button>
        </div>

        <div class="pt-6 border-t border-border">
            <label class="block text-xs font-mono text-text-muted uppercase mb-2">Anonymous Handle</label>
            <div class="flex items-center gap-3">
                <div class="flex-grow h-11 px-4 rounded-xl bg-surface-raised border border-border text-sm font-mono text-text-primary flex items-center">
                    FieldReady_72
                </div>
                <x-ui.button variant="secondary" size="md" icon="dice-5">
                    Roll
                </x-ui.button>
            </div>
            <p class="text-xs text-text-muted mt-2">Generated cryptographically. Your personal identity is never stored.</p>
        </div>

        <div class="mt-8 pt-4 flex justify-end">
            <x-ui.button variant="primary" size="md" iconRight="arrow-right" onclick="window.location.href='/dashboard'">
                Enter Member Workbench
            </x-ui.button>
        </div>
    </x-ui.card>
</div>