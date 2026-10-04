<div class="mx-auto max-w-5xl py-8 px-4">
    <!-- Header -->
    <div class="mb-8">
        <div class="text-xs font-mono text-tactical-steel mb-2">VETTED PRACTITIONER NETWORK</div>
        <h1 class="text-3xl font-extrabold text-content-primary">Male-Competent Clinical Directory</h1>
        <p class="mt-2 text-sm text-content-secondary max-w-2xl leading-relaxed">
            Licensed therapists, psychologists, and clinical social workers specialized in male communication dynamics, operational burnout, trauma, and life rebuilding.
        </p>
    </div>

    <!-- Filter Control Bar -->
    <div class="rounded-xl border border-surface-border bg-surface-card p-4 sm:p-6 mb-8 shadow-lg">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Search Text -->
            <div>
                <label class="block text-xs font-mono text-content-muted mb-1.5">SEARCH DIRECTORY</label>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search by title, specialty, trauma..."
                    class="w-full rounded-lg border border-surface-border bg-surface-base px-3 py-2 text-xs text-content-primary focus:border-tactical-steel focus:ring-1 focus:ring-tactical-steel placeholder:text-content-muted"
                >
            </div>

            <!-- Specialty Filter -->
            <div>
                <label class="block text-xs font-mono text-content-muted mb-1.5">SPECIALTY DOMAIN</label>
                <select 
                    wire:model.live="selectedSpecialty"
                    class="w-full rounded-lg border border-surface-border bg-surface-base px-3 py-2 text-xs text-content-primary focus:border-tactical-steel focus:ring-1 focus:ring-tactical-steel"
                >
                    <option value="">All Clinical Specialties</option>
                    @foreach($specialties as $specialty)
                        <option value="{{ $specialty->slug }}">{{ $specialty->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- State / Jurisdiction Filter -->
            <div>
                <label class="block text-xs font-mono text-content-muted mb-1.5">LICENSING JURISDICTION</label>
                <select 
                    wire:model.live="selectedJurisdiction"
                    class="w-full rounded-lg border border-surface-border bg-surface-base px-3 py-2 text-xs text-content-primary focus:border-tactical-steel focus:ring-1 focus:ring-tactical-steel"
                >
                    <option value="">All States & Jurisdictions</option>
                    @foreach($jurisdictions as $jurisdiction)
                        <option value="{{ $jurisdiction }}">{{ $jurisdiction }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Clinicians Grid -->
    <div class="space-y-4">
        @forelse($clinicians as $clinician)
            <div class="rounded-xl border border-surface-border bg-surface-card p-6 shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-6 hover:border-surface-hover transition">
                <div class="space-y-3 max-w-xl">
                    <!-- Title & Verified Badge -->
                    <div class="flex items-center gap-2.5">
                        <h2 class="text-xl font-bold text-content-primary">{{ $clinician->professional_title }}</h2>
                        <span class="inline-flex items-center gap-1 rounded bg-tactical-success/10 border border-tactical-success/30 px-2 py-0.5 text-[10px] font-mono text-tactical-success">
                            <span>✓</span> LICENSED
                        </span>
                    </div>

                    <!-- Jurisdiction & Call-Sign -->
                    <div class="text-xs font-mono text-content-muted">
                        Callsign: <strong class="text-content-secondary">{{ $clinician->user?->profile?->public_handle ?? 'Provider' }}</strong>
                        • {{ $clinician->licensing_state_or_jurisdiction }} Board Verified
                    </div>

                    <!-- Bio Summary -->
                    <p class="text-xs text-content-secondary leading-relaxed">
                        {{ $clinician->bio_summary }}
                    </p>

                    <!-- Specialty Badges -->
                    <div class="flex flex-wrap gap-1.5 pt-1">
                        @foreach($clinician->specialties as $spec)
                            <span class="rounded bg-surface-base border border-surface-border px-2 py-0.5 text-[10px] font-mono text-tactical-steel">
                                # {{ $spec->name }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Rate & Booking CTA -->
                <div class="text-left sm:text-right flex-shrink-0 border-t sm:border-t-0 border-surface-border pt-4 sm:pt-0">
                    <div class="text-[11px] font-mono text-content-muted">HOURLY RATE</div>
                    <div class="text-2xl font-extrabold font-mono text-content-primary">
                        ${{ number_format($clinician->hourly_rate_cents / 100) }}
                        <span class="text-xs font-normal text-content-muted">/ 50m</span>
                    </div>

                    <button 
                        type="button"
                        wire:click="openBooking({{ $clinician->id }})"
                        class="mt-4 rounded-lg bg-content-primary px-5 py-2.5 text-xs font-mono font-bold text-surface-base hover:bg-white transition shadow-lg"
                    >
                        Book Consultation ➔
                    </button>
                </div>
            </div>
        @empty
            <div class="rounded-xl border border-surface-border bg-surface-card p-12 text-center text-xs font-mono text-content-muted">
                No clinicians match the selected filters.
            </div>
        @endforelse
    </div>

    <!-- Active Booking Modal -->
    @if($bookingClinicianId)
        <livewire:directory.booking-modal :clinicianId="$bookingClinicianId" wire:key="booking-modal-{{ $bookingClinicianId }}" />
    @endif
</div>