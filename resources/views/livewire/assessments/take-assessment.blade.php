<div class="mx-auto max-w-2xl py-8 px-4">

    <!-- ============================================================== -->
    <!-- STATE 1: IMMEDIATE CRISIS INTERCEPT SCREEN (Q9 > 0)            -->
    <!-- ============================================================== -->
    @if($isCrisisTriggered)
        <div class="rounded-xl border-2 border-tactical-danger bg-surface-card p-6 sm:p-10 shadow-2xl text-center">
            <div class="inline-flex items-center gap-2 rounded-full border border-tactical-danger/40 bg-tactical-danger/10 px-4 py-1.5 text-xs font-mono text-tactical-danger mb-4">
                <span class="h-2 w-2 rounded-full bg-tactical-danger animate-ping"></span>
                <span>URGENT SAFETY PROTOCOL ACTIVE</span>
            </div>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-content-primary">
                You Do Not Have to Carry This Alone.
            </h1>

            <p class="mt-3 text-sm text-content-secondary max-w-lg mx-auto leading-relaxed">
                Your response indicates intense distress. Right now, what matters most is connecting with someone who understands how to navigate this pressure safely.
            </p>

            <!-- Direct Contact Hotlines -->
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($emergencyHotlines as $hotline)
                    <div class="rounded-lg border border-surface-border bg-surface-base p-4 text-left">
                        <div class="text-xs font-mono text-tactical-steel">
                            {{ $hotline->is_veteran_specific ? 'VETERANS & FIRST RESPONDERS' : 'CONFIDENTIAL 24/7 SUPPORT' }}
                        </div>
                        <div class="mt-1 text-base font-bold text-content-primary">{{ $hotline->resource_name }}</div>
                        <div class="mt-3 flex items-center gap-2">
                            <a 
                                href="tel:{{ $hotline->phone_number }}" 
                                class="flex-1 rounded bg-tactical-danger px-3 py-2 text-center text-xs font-mono font-bold text-white transition hover:bg-red-600"
                            >
                                📞 Call {{ $hotline->phone_number }}
                            </a>
                            @if($hotline->sms_number)
                                <a 
                                    href="sms:{{ $hotline->sms_number }}" 
                                    class="rounded border border-surface-border bg-surface-hover px-3 py-2 text-center text-xs font-mono text-content-secondary hover:text-content-primary transition"
                                >
                                    💬 Text {{ $hotline->sms_number }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Grounding Sensory Instruction -->
            <div class="mt-8 rounded-lg border border-surface-border bg-surface-base/60 p-4 text-xs text-content-muted leading-relaxed text-left">
                <strong class="text-content-secondary">Immediate Grounding Step:</strong> Drop your shoulders away from your ears. Unclench your jaw. Drink a glass of cold water and connect with one of the free, anonymous hotlines above.
            </div>

            <div class="mt-6">
                <a 
                    href="/tools/breathing" 
                    wire:navigate
                    class="inline-block text-xs font-mono text-tactical-steel hover:underline"
                >
                    ➔ Open Autonomic Down-Regulation Engine
                </a>
            </div>
        </div>

    <!-- ============================================================== -->
    <!-- STATE 2: OUTCOME DEBRIEF SCREEN (COMPLETED NON-ACUTE)          -->
    <!-- ============================================================== -->
    @elseif($isCompleted && $submission)
        @php
            $tier = \App\Enums\RiskClassification::tryFrom($submission->risk_classification);
        @endphp

        <div class="rounded-xl border border-surface-border bg-surface-card p-6 sm:p-10 shadow-2xl">
            <div class="text-xs font-mono text-tactical-steel mb-2">AUDIT COMPLETED // SCORE DEBRIEF</div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-content-primary">Operational Capacity Assessment</h1>
            <p class="mt-1 text-sm text-content-secondary">Based on validated clinical scoring across the last 14 days.</p>

            <!-- Metric Overview Card -->
            <div class="mt-6 rounded-lg border border-surface-border bg-surface-base p-6 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <div class="text-xs font-mono text-content-muted">TOTAL LOAD RATING</div>
                    <div class="mt-1 text-4xl font-extrabold font-mono text-tactical-steel">
                        {{ $submission->total_score }} <span class="text-sm font-normal text-content-muted">/ 27</span>
                    </div>
                </div>

                <div class="text-right sm:text-right">
                    <div class="text-xs font-mono text-content-muted">CURRENT CLASSIFICATION</div>
                    <div class="mt-1 text-lg font-bold text-content-primary">
                        {{ $tier ? $tier->label() : strtoupper($submission->risk_classification) }}
                    </div>
                </div>
            </div>

            <!-- Tactical Analysis -->
            <div class="mt-6 space-y-3 text-sm text-content-secondary leading-relaxed">
                <p>
                    Your baseline indicates that high demands are placing continuous strain on your autonomic recovery. Mental fatigue and irritability are biological indicators that energy expenditure is outstripping daily replenishment.
                </p>
            </div>

            <!-- Recommended Next Field Protocols -->
            <div class="mt-8 border-t border-surface-border pt-6">
                <div class="text-xs font-mono text-content-muted mb-4">RECOMMENDED COUNTER-MEASURES</div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a href="/tools/breathing" wire:navigate class="rounded-lg border border-surface-border bg-surface-base p-4 hover:border-tactical-steel transition">
                        <div class="text-xs font-mono text-tactical-steel">SOMATIC</div>
                        <div class="text-sm font-bold text-content-primary mt-1">4-4-4-4 Box Breathing</div>
                        <p class="text-xs text-content-muted mt-1">Execute 4 cycles to lower baseline irritability.</p>
                    </a>
                    <a href="/#protocols" wire:navigate class="rounded-lg border border-surface-border bg-surface-base p-4 hover:border-tactical-steel transition">
                        <div class="text-xs font-mono text-tactical-amber">LMS TRACK</div>
                        <div class="text-sm font-bold text-content-primary mt-1">The Burnout Reset Protocol</div>
                        <p class="text-xs text-content-muted mt-1">7-day progressive circadian and cognitive reset.</p>
                    </a>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="/" wire:navigate class="rounded-lg bg-content-primary px-6 py-2.5 text-sm font-semibold text-surface-base transition hover:bg-white">
                    Return to Dashboard ➔
                </a>
            </div>
        </div>

    <!-- ============================================================== -->
    <!-- STATE 3: ACTIVE STEP-BY-STEP QUESTION CARD                    -->
    <!-- ============================================================== -->
    @else
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between text-xs font-mono text-content-muted mb-2">
                <span>QUESTION {{ $currentIndex + 1 }} OF {{ $totalQuestions }}</span>
                <span>OVER THE LAST 2 WEEKS</span>
            </div>
            <div class="h-1.5 w-full bg-surface-card rounded-full overflow-hidden border border-surface-border">
                <div 
                    class="h-full bg-tactical-steel transition-all duration-300"
                    style="width: {{ (($currentIndex + 1) / $totalQuestions) * 100 }}%"
                ></div>
            </div>
        </div>

        @if($currentQuestion)
            <div class="rounded-xl border border-surface-border bg-surface-card p-6 sm:p-10 shadow-2xl">
                <!-- Question Statement -->
                <h2 class="text-xl sm:text-2xl font-bold text-content-primary leading-snug">
                    {{ $currentQuestion->question_text }}
                </h2>

                <p class="mt-2 text-xs text-content-muted font-mono">
                    How often have you experienced this?
                </p>

                <!-- Options Grid (Weights: 0, 1, 2, 3) -->
                <div class="mt-8 space-y-3">
                    @php
                        $options = [
                            0 => ['label' => 'Not at all', 'desc' => 'Zero days or negligible impact.'],
                            1 => ['label' => 'Several days', 'desc' => 'Occasional occurrences during the week.'],
                            2 => ['label' => 'More than half the days', 'desc' => 'Persistent and frequent.'],
                            3 => ['label' => 'Nearly every day', 'desc' => 'Constant and disruptive to daily capacity.'],
                        ];
                    @endphp

                    @foreach($options as $val => $opt)
                        <button 
                            type="button"
                            wire:click="selectAnswer({{ $currentQuestion->id }}, {{ $val }})"
                            class="w-full text-left p-4 rounded-lg border border-surface-border bg-surface-base hover:border-tactical-steel hover:bg-surface-hover transition group"
                        >
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-content-primary group-hover:text-tactical-steel transition">
                                    {{ $opt['label'] }}
                                </span>
                                <span class="text-xs font-mono text-content-muted border border-surface-border rounded px-2 py-0.5">
                                    +{{ $val }} PTS
                                </span>
                            </div>
                            <p class="mt-1 text-xs text-content-muted">{{ $opt['desc'] }}</p>
                        </button>
                    @endforeach
                </div>

                <!-- Navigation Controls -->
                <div class="mt-8 flex items-center justify-between border-t border-surface-border pt-4">
                    <button 
                        type="button"
                        wire:click="previousQuestion"
                        class="text-xs font-mono text-content-muted hover:text-content-primary transition {{ $currentIndex === 0 ? 'invisible' : '' }}"
                    >
                        ← Previous Question
                    </button>
                    <span class="text-[11px] font-mono text-content-muted">AES-256 ENCRYPTED INGESTION</span>
                </div>
            </div>
        @endif

    @endif

</div>