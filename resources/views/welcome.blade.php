<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-3xl text-center">
            <!-- Operational Badge -->
            <div class="inline-flex items-center gap-2 rounded-full border border-surface-border bg-surface-card px-3 py-1 text-xs font-mono text-tactical-steel mb-6">
                <span>SYSTEM ACTIVE</span>
                <span class="h-1.5 w-1.5 rounded-full bg-tactical-success animate-pulse"></span>
                <span>ZERO-KNOWLEDGE GUEST ARCHITECTURE</span>
            </div>

            <!-- Tactical Heading -->
            <h1 class="text-3xl font-extrabold tracking-tight sm:text-5xl text-content-primary">
                Operational Resilience &amp; Stress Mastery for Men
            </h1>

            <!-- Value Proposition -->
            <p class="mt-4 text-base sm:text-lg text-content-secondary leading-relaxed">
                Pragmatic mental performance, stress regulation protocols, and restorative sleep mechanics. Zero psychobabble. Validated clinical tools delivered with complete anonymity.
            </p>

            <!-- Quick Action Triggers -->
            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                <a 
                    href="/onboarding" 
                    wire:navigate 
                    class="rounded bg-content-primary px-5 py-2.5 text-sm font-semibold text-surface-base transition hover:bg-white shadow-lg"
                >
                    Launch Readiness Audit
                </a>
                <a 
                    href="/programs" 
                    wire:navigate 
                    class="rounded border border-surface-border bg-surface-card px-5 py-2.5 text-sm font-semibold text-content-primary transition hover:bg-surface-hover"
                >
                    Explore Field Protocols
                </a>
            </div>
        </div>

        <!-- Tactical Surface Cards Preview (3-Column Grid) -->
        <div class="mt-16 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <a 
                href="/tools/breathing" 
                wire:navigate 
                class="block rounded-lg border border-surface-border bg-surface-card p-5 hover:border-tactical-steel transition group"
            >
                <div class="text-xs font-mono text-tactical-steel">REGULATION</div>
                <div class="mt-2 text-xl font-bold group-hover:text-tactical-steel transition">Box Breathing Engine ➔</div>
                <p class="mt-1 text-xs text-content-muted">Mechanical down-regulation of sympathetic overdrive via paced visual breathing.</p>
            </a>

            <a 
                href="/assessments/phq-9" 
                wire:navigate 
                class="block rounded-lg border border-surface-border bg-surface-card p-5 hover:border-tactical-amber transition group"
            >
                <div class="text-xs font-mono text-tactical-amber">CLINICAL AUDIT</div>
                <div class="mt-2 text-xl font-bold group-hover:text-tactical-amber transition">PHQ-9 Capacity Tracker ➔</div>
                <p class="mt-1 text-xs text-content-muted">Standardized mood and fatigue scoring with real-time duty-of-care crisis interceptors.</p>
            </a>

            <a 
                href="/dashboard" 
                wire:navigate 
                class="block rounded-lg border border-surface-border bg-surface-card p-5 hover:border-tactical-olive transition group"
            >
                <div class="text-xs font-mono text-tactical-olive">COGNITIVE DRILL</div>
                <div class="mt-2 text-xl font-bold group-hover:text-tactical-olive transition">CBT Thought Debrief ➔</div>
                <p class="mt-1 text-xs text-content-muted">AES-256 encrypted thought restructuring records to eliminate catastrophic cognitive distortions.</p>
            </a>
        </div>
    </div>
</x-app-layout>