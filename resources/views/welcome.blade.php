<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resilience Project — Operational Tools for Sustained Pressure</title>
    <meta name="description" content="A quiet, private platform for stress regulation, deep sleep, focus, and workload endurance. Zero wellness psychobabble. 100% anonymous.">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-canvas text-text-primary min-h-screen flex flex-col selection:bg-teal-500/25 selection:text-text-primary antialiased bg-topographic">

    <!-- 1. HEADER & UNIVERSAL NAVIGATION -->
    <header class="sticky top-0 z-40 bg-canvas/90 backdrop-blur-md border-b border-border transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-xl bg-surface-raised border border-border-strong flex items-center justify-center text-teal-400 group-hover:border-teal-500/40 transition-colors">
                        <x-icon name="compass" size="20" />
                    </div>
                    <div>
                        <span class="font-serif font-semibold text-lg tracking-tight text-text-primary block leading-none">Resilience Project</span>
                        <span class="text-[10px] font-mono text-text-muted tracking-widest uppercase mt-0.5 block">Zero-Knowledge Care</span>
                    </div>
                </a>

                <nav class="hidden md:flex items-center gap-6 text-sm text-text-secondary">
                    <a href="#how-it-works" class="hover:text-text-primary transition-colors">How It Works</a>
                    <a href="#tools" class="hover:text-text-primary transition-colors">Tactical Tools</a>
                    <a href="#programs" class="hover:text-text-primary transition-colors">Protocols</a>
                    <a href="#squads" class="hover:text-text-primary transition-colors">Squads</a>
                    <a href="#clinicians" class="hover:text-text-primary transition-colors">Clinicians</a>
                    <a href="#privacy" class="hover:text-text-primary transition-colors">Air-Gap Privacy</a>
                </nav>
            </div>

            <div class="flex items-center gap-3">
                <a 
                    href="https://weather.com" 
                    id="quick-exit-btn"
                    onclick="window.location.replace('https://weather.com'); return false;"
                    class="h-10 px-3.5 rounded-xl bg-surface border border-border hover:bg-surface-raised text-text-muted hover:text-brick text-xs font-mono transition-colors flex items-center gap-2"
                    title="Press ESC to quickly leave this site"
                >
                    <x-icon name="log-out" size="16" />
                    <span class="hidden sm:inline">Quick Exit [ESC]</span>
                </a>

                <x-ui.button variant="primary" size="md" onclick="window.location.href='/onboarding'">
                    Start Anonymously
                </x-ui.button>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <!-- 2. HERO SECTION -->
        <section class="relative pt-16 pb-24 lg:pt-24 lg:pb-32 overflow-hidden border-b border-border">
            <div class="absolute inset-0 bg-dawn-gradient pointer-events-none" aria-hidden="true"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                <div class="grid lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                    <div class="lg:col-span-7">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-surface border border-border text-teal-400 font-mono text-xs mb-6">
                            <span class="w-2 h-2 rounded-full bg-teal-400 animate-pulse"></span>
                            <span>Un-pathologized resilience for men</span>
                        </div>

                        <!-- Headline choice: "Load is a fact, not a flaw." (Alternative: "Pressure is physical. So is the way out.") -->
                        <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-semibold text-text-primary tracking-tight leading-[1.12]">
                            Load is a fact, <br class="hidden sm:inline" />
                            <span class="text-copper-400">not a personal flaw.</span>
                        </h1>

                        <p class="mt-6 text-lg sm:text-xl text-text-secondary max-w-2xl leading-relaxed">
                            Mechanics over psychobabble. Regulate your autonomic nervous system, restore fragmented sleep, and rebuild daily operational capacity without clinical jargon or exposure.
                        </p>

                        <div class="mt-9 flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                            <x-ui.button variant="primary" size="lg" iconRight="arrow-right" onclick="window.location.href='/onboarding'">
                                Start without an account
                            </x-ui.button>

                            <x-ui.button variant="secondary" size="lg" onclick="document.getElementById('how-it-works').scrollIntoView({ behavior: 'smooth' })">
                                See how it works
                            </x-ui.button>
                        </div>

                        <div class="mt-5 flex items-center gap-4 text-xs font-mono text-text-muted">
                            <span class="flex items-center gap-1.5">
                                <x-icon name="check-circle" size="16" class="text-teal-400" />
                                No legal name
                            </span>
                            <span class="w-1 h-1 rounded-full bg-border-strong"></span>
                            <span class="flex items-center gap-1.5">
                                <x-icon name="check-circle" size="16" class="text-teal-400" />
                                No credit card
                            </span>
                            <span class="w-1 h-1 rounded-full bg-border-strong"></span>
                            <span class="flex items-center gap-1.5">
                                <x-icon name="check-circle" size="16" class="text-teal-400" />
                                Leave anytime
                            </span>
                        </div>
                    </div>

                    <!-- Hero Visual Frame with Dawn Treatment & SVG Topographic Contour Fallback -->
                    <div class="lg:col-span-5">
                        <div class="relative rounded-2xl bg-surface border border-border p-2 shadow-card-glow">
                            <div class="relative h-96 rounded-xl overflow-hidden bg-surface-raised flex flex-col justify-end p-6 border border-border">
                                <div class="absolute inset-0 bg-gradient-to-tr from-copper-900/40 via-surface to-teal-900/30"></div>
                                <div class="absolute inset-0 bg-topographic opacity-30"></div>

                                <div class="relative z-10">
                                    <div class="flex items-center gap-2 text-xs font-mono text-copper-400 mb-2">
                                        <x-icon name="activity" size="16" />
                                        <span>PHYSIOLOGICAL GROUNDING</span>
                                    </div>
                                    <h3 class="font-serif text-xl font-medium text-text-primary">
                                        "When overload hits, words do not fix physiology. Action does."
                                    </h3>
                                    <p class="text-xs text-text-muted mt-2">
                                        First light protocol &middot; Box breathing &middot; 4 minutes
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. TRUST STRIP -->
        <section class="py-10 border-b border-border bg-ink-950/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-8">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-surface border border-border flex items-center justify-center text-teal-400 flex-shrink-0">
                            <x-icon name="shield-check" size="20" />
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-text-primary">Anonymous by Default</div>
                            <div class="text-xs text-text-muted">No legal names required</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-surface border border-border flex items-center justify-center text-teal-400 flex-shrink-0">
                            <x-icon name="lock" size="20" />
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-text-primary">Encrypted at Rest</div>
                            <div class="text-xs text-text-muted">AES-256 air-gapped data</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-surface border border-border flex items-center justify-center text-teal-400 flex-shrink-0">
                            <x-icon name="eye-off" size="20" />
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-text-primary">Zero Trackers</div>
                            <div class="text-xs text-text-muted">No Meta or Google pixels</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-surface border border-border flex items-center justify-center text-teal-400 flex-shrink-0">
                            <x-icon name="log-out" size="20" />
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-text-primary">Quick Exit Ready</div>
                            <div class="text-xs text-text-muted">One keystroke history wipe</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. WHERE YOU MIGHT BE STARTING -->
        <section class="py-20 lg:py-28 border-b border-border">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <x-ui.section-header 
                    overline="Situational Entry Points"
                    title="Where you might be standing right now."
                    description="We do not put diagnostic labels on men. We address the physical strain you are currently carrying."
                />

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <x-ui.card variant="interactive" onclick="window.location.href='/programs'">
                        <div class="w-10 h-10 rounded-xl bg-surface-raised border border-border flex items-center justify-center text-copper-400 mb-5">
                            <x-icon name="flame" size="20" />
                        </div>
                        <h3 class="font-serif text-lg font-medium text-text-primary mb-2">Running on empty with zero time</h3>
                        <p class="text-sm text-text-secondary leading-relaxed mb-6">Carrying the mortgage, team, and family. Waking up at 3 AM with a racing mind and physical tension.</p>
                        <div class="flex items-center text-xs font-mono text-copper-400">
                            <span>Burnout Reset Protocol</span>
                            <x-icon name="chevron-right" size="16" class="ml-1" />
                        </div>
                    </x-ui.card>

                    <x-ui.card variant="interactive" onclick="window.location.href='/tools/breathing'">
                        <div class="w-10 h-10 rounded-xl bg-surface-raised border border-border flex items-center justify-center text-teal-400 mb-5">
                            <x-icon name="anchor" size="20" />
                        </div>
                        <h3 class="font-serif text-lg font-medium text-text-primary mb-2">Hands-on, wary of all this</h3>
                        <p class="text-sm text-text-secondary leading-relaxed mb-6">Physical strain, daily soreness, and unwinding with alcohol. You want your nervous system to stop humming.</p>
                        <div class="flex items-center text-xs font-mono text-teal-400">
                            <span>Somatic Reset Drills</span>
                            <x-icon name="chevron-right" size="16" class="ml-1" />
                        </div>
                    </x-ui.card>

                    <x-ui.card variant="interactive" onclick="window.location.href='/dashboard'">
                        <div class="w-10 h-10 rounded-xl bg-surface-raised border border-border flex items-center justify-center text-dusk-400 mb-5">
                            <x-icon name="compass" size="20" />
                        </div>
                        <h3 class="font-serif text-lg font-medium text-text-primary mb-2">Stuck, scrolling, unable to decide</h3>
                        <p class="text-sm text-text-secondary leading-relaxed mb-6">Paralyzed by what move to make next. Spending hours behind screens feeling isolated and behind in life.</p>
                        <div class="flex items-center text-xs font-mono text-dusk-400">
                            <span>Readiness & Momentum Tracking</span>
                            <x-icon name="chevron-right" size="16" class="ml-1" />
                        </div>
                    </x-ui.card>

                    <x-ui.card variant="interactive" onclick="window.location.href='/squads'">
                        <div class="w-10 h-10 rounded-xl bg-surface-raised border border-border flex items-center justify-center text-brass mb-5">
                            <x-icon name="mountain" size="20" />
                        </div>
                        <h3 class="font-serif text-lg font-medium text-text-primary mb-2">Starting over after a major change</h3>
                        <p class="text-sm text-text-secondary leading-relaxed mb-6">Separation, divorce, or loss of career identity. Your prior support structure disappeared and you need to rebuild.</p>
                        <div class="flex items-center text-xs font-mono text-brass">
                            <span>Rebuild Cohorts & Squads</span>
                            <x-icon name="chevron-right" size="16" class="ml-1" />
                        </div>
                    </x-ui.card>
                </div>
            </div>
        </section>

        <!-- 5. HOW IT WORKS -->
        <section id="how-it-works" class="py-20 lg:py-28 border-b border-border bg-ink-950/40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <x-ui.section-header 
                    overline="Methodology"
                    title="A clear sequence. No guessing."
                    description="Designed to deliver practical autonomic relief in under four minutes, building toward sustained behavioral endurance."
                />

                <div class="grid md:grid-cols-4 gap-8">
                    <div>
                        <div class="text-xs font-mono text-teal-400 mb-2">STEP 01</div>
                        <div class="w-12 h-12 rounded-xl bg-surface border border-border flex items-center justify-center text-text-primary mb-4">
                            <x-icon name="sunrise" size="22" />
                        </div>
                        <h3 class="font-serif text-lg font-medium text-text-primary mb-2">Take the 30s Audit</h3>
                        <p class="text-sm text-text-secondary leading-relaxed">Check energy, irritability, and restorative sleep on a numerical scale without judgment or clinical labels.</p>
                    </div>

                    <div>
                        <div class="text-xs font-mono text-teal-400 mb-2">STEP 02</div>
                        <div class="w-12 h-12 rounded-xl bg-surface border border-border flex items-center justify-center text-text-primary mb-4">
                            <x-icon name="wind" size="22" />
                        </div>
                        <h3 class="font-serif text-lg font-medium text-text-primary mb-2">Apply Somatic Drills</h3>
                        <p class="text-sm text-text-secondary leading-relaxed">Use Box Breathing or the Physiological Sigh to trigger your parasympathetic brake and drop autonomic tension.</p>
                    </div>

                    <div>
                        <div class="text-xs font-mono text-teal-400 mb-2">STEP 03</div>
                        <div class="w-12 h-12 rounded-xl bg-surface border border-border flex items-center justify-center text-text-primary mb-4">
                            <x-icon name="anchor" size="22" />
                        </div>
                        <h3 class="font-serif text-lg font-medium text-text-primary mb-2">Build Momentum</h3>
                        <p class="text-sm text-text-secondary leading-relaxed">Maintain your momentum capital with graceful pauses. Life happens; we never reset your progress to zero.</p>
                    </div>

                    <div>
                        <div class="text-xs font-mono text-teal-400 mb-2">STEP 04</div>
                        <div class="w-12 h-12 rounded-xl bg-surface border border-border flex items-center justify-center text-text-primary mb-4">
                            <x-icon name="stethoscope" size="22" />
                        </div>
                        <h3 class="font-serif text-lg font-medium text-text-primary mb-2">Access Male-Competent Care</h3>
                        <p class="text-sm text-text-secondary leading-relaxed">When ready, schedule confidential, end-to-end encrypted consultations with vetted clinicians who understand male communication.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 6. TOOL SHOWCASE -->
        <section id="tools" class="py-20 lg:py-28 border-b border-border">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <x-ui.section-header 
                    overline="Tactical Engine"
                    title="Real tools. Designed for daily operational use."
                    description="Constructed for the real world: on your phone in the truck, before a high-stakes meeting, or at midnight when your brain won't shut off."
                />

                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Tool 1: Somatic Pacer Mockup -->
                    <x-ui.card class="flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between text-xs font-mono text-text-muted mb-4">
                                <span class="text-teal-400">TOOL // SOMATIC_PACER</span>
                                <span>4-4-4-4 PATTERN</span>
                            </div>
                            <h3 class="font-serif text-xl font-medium text-text-primary mb-2">Box Breathing Engine</h3>
                            <p class="text-xs text-text-secondary mb-6">Mechanically forces carbon dioxide buildup, activating the vagus nerve and slowing heart rate.</p>
                            
                            <div class="h-44 rounded-xl bg-surface-raised border border-border flex flex-col items-center justify-center p-4">
                                <div class="w-20 h-20 rounded-full border-2 border-teal-400/40 flex items-center justify-center text-teal-300 font-mono text-sm shadow-teal-glow">
                                    HOLD 4s
                                </div>
                                <span class="text-[11px] font-mono text-text-muted mt-3">Visual feedback &middot; Alpine.js</span>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-border flex items-center justify-between">
                            <span class="text-xs text-text-muted">No audio required</span>
                            <a href="/tools/breathing" class="text-xs font-mono text-teal-400 hover:text-teal-300">Launch drill &rarr;</a>
                        </div>
                    </x-ui.card>

                    <!-- Tool 2: Daily Readiness Mockup -->
                    <x-ui.card class="flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between text-xs font-mono text-text-muted mb-4">
                                <span class="text-copper-400">TOOL // READINESS_AUDIT</span>
                                <span>30 SECONDS</span>
                            </div>
                            <h3 class="font-serif text-xl font-medium text-text-primary mb-2">Readiness Matrix</h3>
                            <p class="text-xs text-text-secondary mb-6">Quantify biological capacity before making commitments. Identifies burnout signals early.</p>

                            <div class="space-y-3 p-3 rounded-xl bg-surface-raised border border-border">
                                <div>
                                    <div class="flex justify-between text-[11px] font-mono text-text-secondary mb-1">
                                        <span>Drive & Focus</span>
                                        <span class="text-copper-400">7 / 10</span>
                                    </div>
                                    <div class="h-2 rounded-full bg-surface overflow-hidden">
                                        <div class="h-full bg-copper-500 rounded-full w-[70%]"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-[11px] font-mono text-text-secondary mb-1">
                                        <span>Restorative Sleep</span>
                                        <span class="text-teal-400">8 / 10</span>
                                    </div>
                                    <div class="h-2 rounded-full bg-surface overflow-hidden">
                                        <div class="h-full bg-teal-500 rounded-full w-[80%]"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-border flex items-center justify-between">
                            <span class="text-xs text-text-muted">Auto-saves to browser</span>
                            <a href="/dashboard" class="text-xs font-mono text-copper-400 hover:text-copper-300">Open audit &rarr;</a>
                        </div>
                    </x-ui.card>

                    <!-- Tool 3: CBT Thought Debrief Mockup -->
                    <x-ui.card class="flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between text-xs font-mono text-text-muted mb-4">
                                <span class="text-dusk-400">TOOL // COGNITIVE_DEBRIEF</span>
                                <span>AES-256</span>
                            </div>
                            <h3 class="font-serif text-xl font-medium text-text-primary mb-2">CBT Thought Record</h3>
                            <p class="text-xs text-text-secondary mb-6">Three columns: Event &rarr; Catastrophic Thought &rarr; Rational Reframe. Encrypted at rest.</p>

                            <div class="p-3 rounded-xl bg-surface-raised border border-border text-xs space-y-2">
                                <div class="text-[11px] font-mono text-text-muted uppercase">Rational Reframe:</div>
                                <div class="text-text-secondary italic">
                                    "A delayed contract is not proof of failure. The data shows 85% close rate this quarter."
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-border flex items-center justify-between">
                            <span class="text-xs text-text-muted">Zero-knowledge storage</span>
                            <a href="/dashboard" class="text-xs font-mono text-dusk-400 hover:text-dusk-300">Open journal &rarr;</a>
                        </div>
                    </x-ui.card>
                </div>
            </div>
        </section>

        <!-- 7. PROGRAMS PREVIEW -->
        <section id="programs" class="py-20 lg:py-28 border-b border-border bg-ink-950/40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                    <x-ui.section-header 
                        overline="Operational Tracks"
                        title="Structured psychoeducational programs."
                        description="Self-paced, bite-sized modules built for commute audio listening or 5-minute evening debriefs."
                        class="mb-0"
                    />

                    <x-ui.button variant="secondary" size="md" onclick="window.location.href='/programs'" class="mt-4 md:mt-0">
                        View All Programs
                    </x-ui.button>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <x-ui.card>
                        <div class="text-xs font-mono text-copper-400 mb-2">7-DAY PROTOCOL</div>
                        <h3 class="font-serif text-xl font-medium text-text-primary mb-2">The Burnout Reset Protocol</h3>
                        <p class="text-sm text-text-secondary mb-6">Halt physiological depletion, drop cortisol spikes, and realign work capacity without quitting your career.</p>
                        <div class="flex items-center gap-4 text-xs font-mono text-text-muted">
                            <span class="flex items-center gap-1.5"><x-icon name="headphones" size="14" /> Audio mode</span>
                            <span class="flex items-center gap-1.5"><x-icon name="clock" size="14" /> 5m / day</span>
                        </div>
                    </x-ui.card>

                    <x-ui.card>
                        <div class="text-xs font-mono text-teal-400 mb-2">14-DAY PROTOCOL</div>
                        <h3 class="font-serif text-xl font-medium text-text-primary mb-2">Circadian Realignment & Sleep</h3>
                        <p class="text-sm text-text-secondary mb-6">Tailored for shift workers and high-stress executive insomnia. Rebuilding architecture of deep sleep.</p>
                        <div class="flex items-center gap-4 text-xs font-mono text-text-muted">
                            <span class="flex items-center gap-1.5"><x-icon name="headphones" size="14" /> Audio mode</span>
                            <span class="flex items-center gap-1.5"><x-icon name="clock" size="14" /> 6m / day</span>
                        </div>
                    </x-ui.card>

                    <x-ui.card>
                        <div class="text-xs font-mono text-brass mb-2">21-DAY PROTOCOL</div>
                        <h3 class="font-serif text-xl font-medium text-text-primary mb-2">Post-Separation Rebuild</h3>
                        <p class="text-sm text-text-secondary mb-6">Navigating custody pressure, financial disorientation, and rebuilding masculine self-worth.</p>
                        <div class="flex items-center gap-4 text-xs font-mono text-text-muted">
                            <span class="flex items-center gap-1.5"><x-icon name="headphones" size="14" /> Audio mode</span>
                            <span class="flex items-center gap-1.5"><x-icon name="clock" size="14" /> 7m / day</span>
                        </div>
                    </x-ui.card>
                </div>
            </div>
        </section>

        <!-- 8. PEER SQUADS PREVIEW -->
        <section id="squads" class="py-20 lg:py-28 border-b border-border">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <x-ui.section-header 
                    overline="Solidarity Without Vanity"
                    title="Topic-specific peer squads."
                    description="No likes, no follower counts, no algorithmic performance. Moderated discussions with non-competitive reactions."
                />

                <div class="grid lg:grid-cols-2 gap-8">
                    <x-ui.card>
                        <div class="flex items-center justify-between pb-4 border-b border-border mb-4">
                            <div class="flex items-center gap-3">
                                <x-ui.avatar name="IronOak" size="sm" />
                                <div>
                                    <div class="text-sm font-semibold text-text-primary">IronOak_42</div>
                                    <div class="text-[11px] font-mono text-text-muted">in # Executive & Career Isolation</div>
                                </div>
                            </div>
                            <span class="text-xs font-mono text-text-muted">2h ago</span>
                        </div>

                        <p class="text-sm text-text-secondary leading-relaxed mb-6">
                            "First day in three months I shut my laptop at 6:30 PM. Did the 4-4-4-4 breathing in the truck before walking in the door. My kids noticed I wasn't irritable. Small win, but it counts."
                        </p>

                        <div class="flex items-center gap-3 text-xs font-mono text-text-muted">
                            <span class="px-2.5 py-1 rounded-lg bg-surface-raised border border-border flex items-center gap-1.5 text-teal-400">
                                <x-icon name="shield-check" size="14" /> Solidarity (14)
                            </span>
                            <span class="px-2.5 py-1 rounded-lg bg-surface-raised border border-border flex items-center gap-1.5 text-text-secondary">
                                <x-icon name="activity" size="14" /> Heard (9)
                            </span>
                        </div>
                    </x-ui.card>

                    <x-ui.card>
                        <div class="flex items-center justify-between pb-4 border-b border-border mb-4">
                            <div class="flex items-center gap-3">
                                <x-ui.avatar name="FieldOps" size="sm" />
                                <div>
                                    <div class="text-sm font-semibold text-text-primary">FieldOps_91</div>
                                    <div class="text-[11px] font-mono text-text-muted">in # Trades & Physical Labor</div>
                                </div>
                            </div>
                            <span class="text-xs font-mono text-text-muted">5h ago</span>
                        </div>

                        <p class="text-sm text-text-secondary leading-relaxed mb-6">
                            "Cut the after-work beers from 5 to zero this week. Replaced it with a 15-minute walk and cold shower. Back pain is down and I am actually waking up clear-headed."
                        </p>

                        <div class="flex items-center gap-3 text-xs font-mono text-text-muted">
                            <span class="px-2.5 py-1 rounded-lg bg-surface-raised border border-border flex items-center gap-1.5 text-teal-400">
                                <x-icon name="shield-check" size="14" /> Solidarity (27)
                            </span>
                            <span class="px-2.5 py-1 rounded-lg bg-surface-raised border border-border flex items-center gap-1.5 text-copper-400">
                                <x-icon name="anchor" size="14" /> Respect (18)
                            </span>
                        </div>
                    </x-ui.card>
                </div>
            </div>
        </section>

        <!-- 9. CLINICIANS PREVIEW -->
        <section id="clinicians" class="py-20 lg:py-28 border-b border-border bg-ink-950/40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <x-ui.section-header 
                    overline="Verified Practitioners"
                    title="Vetted male-competent clinicians."
                    description="Licensed psychologists and coaches who communicate directly and understand the realities of male burden."
                />

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <x-ui.card class="flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-3.5 mb-4">
                                <x-ui.avatar name="Dr Miller" size="md" />
                                <div>
                                    <h4 class="font-serif font-medium text-text-primary">Marcus Vance Miller, PsyD</h4>
                                    <p class="text-xs text-text-muted">Licensed Clinical Psychologist (CA)</p>
                                </div>
                            </div>
                            <p class="text-xs text-text-secondary leading-relaxed mb-4">
                                Specializing in executive burnout, first responder trauma, and pragmatic cognitive behavioral protocols.
                            </p>
                            <div class="flex flex-wrap gap-1.5 mb-6">
                                <span class="px-2 py-0.5 rounded bg-surface-raised text-[10px] font-mono text-teal-400 border border-border">Executive Burnout</span>
                                <span class="px-2 py-0.5 rounded bg-surface-raised text-[10px] font-mono text-copper-400 border border-border">Divorce Rebuild</span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-border flex items-center justify-between">
                            <span class="text-xs font-mono text-text-muted">$150 / session</span>
                            <x-ui.button variant="secondary" size="sm" onclick="window.location.href='/directory'">
                                View Open Slots
                            </x-ui.button>
                        </div>
                    </x-ui.card>
                </div>
            </div>
        </section>

        <!-- 10. PRIVACY & AIR-GAP ARCHITECTURE -->
        <section id="privacy" class="py-20 lg:py-28 border-b border-border">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <x-ui.section-header 
                    overline="Air-Gap Architecture"
                    title="Your privacy is a product feature, not policy fine print."
                    description="We separate your billing identity from your thoughts and health logs. Even our engineers cannot connect them."
                />

                <div class="p-8 rounded-2xl bg-surface border border-border shadow-card-glow max-w-4xl mx-auto">
                    <div class="grid md:grid-cols-3 gap-8 items-center text-center">
                        <div class="p-4 rounded-xl bg-surface-raised border border-border">
                            <div class="w-10 h-10 rounded-lg bg-surface border border-border mx-auto flex items-center justify-center text-copper-400 mb-3">
                                <x-icon name="lock" size="20" />
                            </div>
                            <div class="text-sm font-semibold text-text-primary">Billing Identity</div>
                            <div class="text-xs text-text-muted mt-1">Stripe customer token &middot; No health link</div>
                        </div>

                        <div class="flex flex-col items-center">
                            <div class="h-px w-full bg-border-strong hidden md:block"></div>
                            <span class="px-3 py-1 rounded bg-canvas border border-teal-500/40 text-[10px] font-mono text-teal-400 my-2">
                                AIR-GAP ENCRYPTION
                            </span>
                            <div class="h-px w-full bg-border-strong hidden md:block"></div>
                        </div>

                        <div class="p-4 rounded-xl bg-surface-raised border border-border">
                            <div class="w-10 h-10 rounded-lg bg-surface border border-border mx-auto flex items-center justify-center text-teal-400 mb-3">
                                <x-icon name="shield-check" size="20" />
                            </div>
                            <div class="text-sm font-semibold text-text-primary">Clinical & Journal Records</div>
                            <div class="text-xs text-text-muted mt-1">AES-256 encrypted &middot; Anonymous UUID</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 11. EMERGENCY SUPPORT BAND -->
        <section class="py-12 border-b border-border bg-surface-raised border-l-4 border-l-brick">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                    <div>
                        <div class="flex items-center gap-2 text-brick font-mono text-xs mb-1">
                            <x-icon name="alert-triangle" size="16" />
                            <span>EMERGENCY DUTY OF CARE</span>
                        </div>
                        <h3 class="font-serif text-xl font-medium text-text-primary">
                            If you are in acute crisis or danger, direct help is immediate.
                        </h3>
                        <p class="text-sm text-text-secondary mt-1">
                            The Resilience Project is not an emergency room. The Suicide & Crisis Lifeline operates 24/7.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="tel:988" class="h-11 px-5 rounded-xl bg-text-primary hover:bg-white text-canvas font-semibold text-sm flex items-center gap-2 shadow-sm">
                            <x-icon name="phone" size="18" />
                            <span>Call 988</span>
                        </a>
                        <a href="sms:988" class="h-11 px-5 rounded-xl bg-surface border border-border hover:bg-surface-hover text-text-primary font-medium text-sm flex items-center gap-2">
                            <x-icon name="message-square" size="18" />
                            <span>Text 988</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- 12. FAQ ACCORDION -->
        <section class="py-20 lg:py-28 border-b border-border bg-ink-950/40">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ active: null }">
                <x-ui.section-header 
                    align="center"
                    overline="Clarity & Boundaries"
                    title="Frequently Asked Questions"
                    description="Straight answers regarding data, anonymity, safety, and clinical boundaries."
                />

                <div class="space-y-4">
                    <div class="rounded-xl bg-surface border border-border p-5 cursor-pointer" @click="active = (active === 1 ? null : 1)">
                        <div class="flex items-center justify-between font-serif font-medium text-text-primary text-base">
                            <span>Do I ever need to enter my real name or credit card?</span>
                            <x-icon name="chevron-down" size="18" class="text-text-muted transition-transform" ::class="active === 1 ? 'rotate-180' : ''" />
                        </div>
                        <div x-show="active === 1" x-collapse class="mt-3 text-sm text-text-secondary leading-relaxed pt-3 border-t border-border">
                            No. You can use all somatic tools, check-ins, and public protocols in 100% anonymous Guest Mode. If you choose to book a clinical consultation, payments are tokenized via Stripe and air-gapped from your behavioral records.
                        </div>
                    </div>

                    <div class="rounded-xl bg-surface border border-border p-5 cursor-pointer" @click="active = (active === 2 ? null : 2)">
                        <div class="flex items-center justify-between font-serif font-medium text-text-primary text-base">
                            <span>What happens if I answer yes to Question 9 on the PHQ-9?</span>
                            <x-icon name="chevron-down" size="18" class="text-text-muted transition-transform" ::class="active === 2 ? 'rotate-180' : ''" />
                        </div>
                        <div x-show="active === 2" x-collapse class="mt-3 text-sm text-text-secondary leading-relaxed pt-3 border-t border-border">
                            Question 9 screens for thoughts of self-harm. Answering greater than zero immediately activates a calm, unclosable safety intercept screen with one-tap dialing for the 988 Lifeline and crisis text lines. We do not call the police on you; we place direct lifelines immediately at your fingertips.
                        </div>
                    </div>

                    <div class="rounded-xl bg-surface border border-border p-5 cursor-pointer" @click="active = (active === 3 ? null : 3)">
                        <div class="flex items-center justify-between font-serif font-medium text-text-primary text-base">
                            <span>Does this platform replace regular talk therapy?</span>
                            <x-icon name="chevron-down" size="18" class="text-text-muted transition-transform" ::class="active === 3 ? 'rotate-180' : ''" />
                        </div>
                        <div x-show="active === 3" x-collapse class="mt-3 text-sm text-text-secondary leading-relaxed pt-3 border-t border-border">
                            No. It functions as a daily operational workbench and self-regulation toolkit. It provides structured grounding, habit accountability, and an on-ramp to verified male-competent therapists when you decide you want professional care.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 13. CLOSING CTA -->
        <section class="py-24 lg:py-32 relative text-center">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-semibold text-text-primary tracking-tight">
                    Start where you are. Right now.
                </h2>
                <p class="mt-4 text-base sm:text-lg text-text-secondary max-w-xl mx-auto">
                    Three minutes. No email. No credit card. Ground your nervous system before the next hour begins.
                </p>
                <div class="mt-8 flex justify-center gap-4">
                    <x-ui.button variant="primary" size="lg" iconRight="arrow-right" onclick="window.location.href='/onboarding'">
                        Enter Without Account
                    </x-ui.button>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="border-t border-border bg-ink-950 py-12 text-xs text-text-muted">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <span class="font-serif font-semibold text-text-secondary text-sm">Resilience Project</span>
                <span>&middot;</span>
                <span>Zero-Knowledge Architecture</span>
            </div>

            <div class="flex items-center gap-6">
                <a href="#privacy" class="hover:text-text-secondary">Air-Gap Privacy</a>
                <a href="/admin" class="hover:text-text-secondary opacity-50 hover:opacity-100 font-mono text-[11px]">Staff Command Center</a>
            </div>

            <div>
                &copy; {{ date('Y') }} Resilience Project. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                window.location.replace('https://weather.com');
            }
        });
    </script>
</body>
</html>