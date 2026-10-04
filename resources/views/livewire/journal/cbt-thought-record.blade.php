<div class="rounded-xl border border-surface-border bg-surface-card p-6 sm:p-8 shadow-xl">
    <div class="flex items-center justify-between border-b border-surface-border pb-4 mb-6">
        <div>
            <div class="text-xs font-mono text-tactical-steel">COGNITIVE RESTRUCTURING // 3-COLUMN RECORD</div>
            <h2 class="text-2xl font-bold text-content-primary">Cognitive Debrief Workbench</h2>
            <p class="mt-1 text-xs text-content-secondary">
                Neutralize cognitive distortions (catastrophizing, mind-reading, black-and-white thinking) with objective counter-evidence.
            </p>
        </div>
        <div class="hidden sm:flex items-center gap-1.5 text-[11px] font-mono text-tactical-success bg-surface-base px-3 py-1 rounded border border-surface-border">
            <span>🔒</span> AES-256 ENCRYPTED AT REST
        </div>
    </div>

    <!-- 3-Column Input Grid -->
    <form wire:submit.prevent="saveEntry" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Column 1: Trigger / Event -->
            <div class="rounded-lg border border-surface-border bg-surface-base p-4">
                <div class="text-xs font-mono text-tactical-steel mb-1">01. SITUATION / TRIGGER</div>
                <label class="block text-[11px] text-content-muted mb-2">What happened objectively? (Just the facts)</label>
                <textarea 
                    wire:model="triggerEvent"
                    rows="4" 
                    placeholder="e.g. Boss sent an urgent email at 7:00 PM asking to review Q3 numbers tomorrow."
                    class="w-full rounded border border-surface-border bg-surface-card p-2.5 text-xs text-content-primary focus:border-tactical-steel focus:ring-1 focus:ring-tactical-steel resize-none"
                ></textarea>
                @error('triggerEvent') <span class="text-[10px] text-tactical-danger font-mono">{{ $message }}</span> @enderror
            </div>

            <!-- Column 2: Automatic Negative Thought -->
            <div class="rounded-lg border border-surface-border bg-surface-base p-4">
                <div class="text-xs font-mono text-tactical-amber mb-1">02. AUTOMATIC DISTORTION</div>
                <label class="block text-[11px] text-content-muted mb-2">What catastrophic thought automatically fired?</label>
                <textarea 
                    wire:model="automaticThought"
                    rows="4" 
                    placeholder="e.g. I am going to get fired. I have let everyone down. I can't handle this job."
                    class="w-full rounded border border-surface-border bg-surface-card p-2.5 text-xs text-content-primary focus:border-tactical-amber focus:ring-1 focus:ring-tactical-amber resize-none"
                ></textarea>
                @error('automaticThought') <span class="text-[10px] text-tactical-danger font-mono">{{ $message }}</span> @enderror
            </div>

            <!-- Column 3: Rational Reframe -->
            <div class="rounded-lg border border-surface-border bg-surface-base p-4">
                <div class="text-xs font-mono text-tactical-olive mb-1">03. TACTICAL REFRAME</div>
                <label class="block text-[11px] text-content-muted mb-2">What is the objective operational reality?</label>
                <textarea 
                    wire:model="rationalReframe"
                    rows="4" 
                    placeholder="e.g. He asks everyone for numbers before meetings. My metrics are solid. I will prepare tomorrow at 8:30 AM."
                    class="w-full rounded border border-surface-border bg-surface-card p-2.5 text-xs text-content-primary focus:border-tactical-olive focus:ring-1 focus:ring-tactical-olive resize-none"
                ></textarea>
                @error('rationalReframe') <span class="text-[10px] text-tactical-danger font-mono">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex items-center justify-between">
            <span x-data="{ show: false }" x-show="$wire.justSaved" x-init="$watch('$wire.justSaved', v => { if(v) { show=true; setTimeout(() => show=false, 3000); } })" x-cloak class="text-xs font-mono text-tactical-success">
                ✓ Encrypted & Saved to Operational Dossier.
            </span>
            <button 
                type="submit" 
                class="rounded-lg bg-content-primary px-6 py-2.5 text-xs font-mono font-bold text-surface-base hover:bg-white transition ml-auto"
            >
                Lock In Reframe
            </button>
        </div>
    </form>

    <!-- Past Decrypted Debrief Entries -->
    @if($recentEntries->isNotEmpty())
        <div class="mt-8 border-t border-surface-border pt-6">
            <div class="text-xs font-mono text-content-muted mb-4">RECENT DEBRIEF LOGS (DECRYPTED ON DEMAND)</div>
            <div class="space-y-3">
                @foreach($recentEntries as $entry)
                    <div class="rounded-lg border border-surface-border bg-surface-base p-4 text-xs">
                        <div class="flex items-center justify-between text-[11px] font-mono text-content-muted mb-2">
                            <span class="text-tactical-steel font-bold">{{ $entry->encrypted_title }}</span>
                            <span>{{ $entry->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="text-content-secondary whitespace-pre-line text-xs font-sans">
                            {{ $entry->encrypted_body }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>