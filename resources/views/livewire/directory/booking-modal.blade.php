<div 
    x-data="{
        closeModal() {
            $wire.close();
        }
    }"
    @keydown.escape.window="closeModal()"
    @click.self="closeModal()"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/85 backdrop-blur-md p-4 transition-opacity"
>
    <div class="w-full max-w-lg rounded-2xl border border-surface-border bg-surface-card p-6 sm:p-8 shadow-2xl relative text-left">
        <!-- Persistent Close Button -->
        <button 
            type="button" 
            wire:click="close"
            class="absolute top-4 right-4 flex h-8 w-8 items-center justify-center rounded-lg border border-surface-border bg-surface-base text-content-muted hover:text-content-primary hover:border-surface-hover transition"
            title="Close Window [Esc]"
        >
            ✕
        </button>

        @if($confirmedAppointment)
            <!-- ========================================== -->
            <!-- STATE: BOOKING CONFIRMED SUCCESS SCREEN    -->
            <!-- ========================================== -->
            <div class="text-center py-4">
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-tactical-success/15 border border-tactical-success/40 text-tactical-success text-2xl mb-4">
                    ✓
                </div>
                <h3 class="text-2xl font-extrabold text-content-primary">Consultation Confirmed</h3>
                <p class="mt-2 text-xs text-content-secondary leading-relaxed max-w-sm mx-auto">
                    Your appointment has been locked in. Identity air-gapping ensures your billing details remain decoupled from your clinical logs.
                </p>

                <!-- Appointment Summary Ticket -->
                <div class="mt-6 rounded-xl border border-surface-border bg-surface-base p-5 text-left font-mono text-xs space-y-3">
                    <div class="flex items-center justify-between border-b border-surface-border pb-2.5">
                        <span class="text-content-muted">APPOINTMENT TOKEN:</span>
                        <span class="text-tactical-steel font-bold">{{ substr($confirmedAppointment->uuid, 0, 8) }}...</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-surface-border pb-2.5">
                        <span class="text-content-muted">PROVIDER:</span>
                        <span class="text-content-primary font-bold">{{ $clinician->professional_title }}</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-surface-border pb-2.5">
                        <span class="text-content-muted">DATE &amp; TIME:</span>
                        <span class="text-tactical-amber font-bold">
                            {{ $confirmedAppointment->scheduled_start_time->format('l, M d, Y @ g:i A') }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-content-muted">TELEHEALTH ROOM:</span>
                        <span class="text-tactical-success font-bold">{{ $confirmedAppointment->telehealth_room_name }}</span>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button 
                        type="button" 
                        wire:click="close"
                        class="w-full sm:w-auto rounded-lg bg-content-primary px-8 py-2.5 text-xs font-mono font-bold text-surface-base hover:bg-white transition shadow-lg"
                    >
                        Done / Return to Directory
                    </button>
                </div>
            </div>
        @else
            <!-- ========================================== -->
            <!-- STATE: SELECT SLOT & BOOK CONSULTATION     -->
            <!-- ========================================== -->
            <div>
                <!-- Provider Header -->
                <div class="pr-8">
                    <div class="inline-flex items-center gap-1.5 rounded-full border border-tactical-steel/30 bg-tactical-steel/10 px-2.5 py-0.5 text-[11px] font-mono text-tactical-steel mb-2">
                        <span>●</span> SECURE TELEHEALTH
                    </div>
                    <h2 class="text-xl font-bold text-content-primary">{{ $clinician->professional_title }}</h2>
                    <div class="mt-1 text-xs text-content-secondary font-mono">
                        {{ $clinician->licensing_state_or_jurisdiction }} Board Certified • ${{ number_format($clinician->hourly_rate_cents / 100) }} / 50-minute session
                    </div>
                </div>

                <!-- Error Notice -->
                @if($errorMessage)
                    <div class="mt-4 rounded-lg border border-tactical-danger/40 bg-tactical-danger/10 p-3 text-xs font-mono text-tactical-danger flex items-center gap-2">
                        <span>⚠</span>
                        <span>{{ $errorMessage }}</span>
                    </div>
                @endif

                <!-- Date Selector -->
                <div class="mt-6">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-xs font-mono text-content-muted">CONSULTATION DATE</label>
                        <span wire:loading wire:target="selectedDate" class="text-[10px] font-mono text-tactical-steel animate-pulse">
                            Checking calendar...
                        </span>
                    </div>
                    <input 
                        type="date" 
                        wire:model.live="selectedDate"
                        min="{{ \Carbon\Carbon::today()->toDateString() }}"
                        class="w-full rounded-lg border border-surface-border bg-surface-base px-3.5 py-2.5 text-xs font-mono text-content-primary focus:border-tactical-steel focus:ring-1 focus:ring-tactical-steel"
                    >
                </div>

                <!-- Open Slots Grid -->
                <div class="mt-6">
                    <div class="flex items-center justify-between text-xs font-mono text-content-muted mb-2.5">
                        <span>AVAILABLE SLOTS</span>
                        <span>{{ $availableSlots->count() }} SLOTS OPEN</span>
                    </div>

                    <div class="max-h-52 overflow-y-auto pr-1 grid grid-cols-2 gap-2">
                        @forelse($availableSlots as $slot)
                            @php
                                $startTime = \Carbon\Carbon::parse($slot['start_time']);
                                $isSelected = $selectedSlot === $slot['start_time'];
                            @endphp
                            <button 
                                type="button"
                                wire:click="selectSlot('{{ $slot['start_time'] }}')"
                                class="p-3 rounded-lg border text-xs font-mono text-center transition {{ $isSelected ? 'border-tactical-steel bg-tactical-steel/20 text-tactical-steel font-bold ring-1 ring-tactical-steel shadow-md' : 'border-surface-border bg-surface-base text-content-primary hover:bg-surface-hover hover:border-surface-hover' }}"
                            >
                                {{ $startTime->format('g:i A') }}
                            </button>
                        @empty
                            <div class="col-span-2 text-center py-8 text-xs font-mono text-content-muted rounded-lg border border-dashed border-surface-border bg-surface-base/40">
                                No consultation slots open on this date.<br>
                                <span class="text-[11px] text-content-secondary mt-1 inline-block">Try selecting Monday or another business day.</span>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Booking Action Footer -->
                <div class="mt-8 flex items-center justify-between border-t border-surface-border pt-5">
                    <button 
                        type="button" 
                        wire:click="close"
                        class="rounded-lg border border-surface-border bg-surface-base px-4 py-2 text-xs font-mono text-content-muted hover:text-content-primary hover:bg-surface-hover transition"
                    >
                        Cancel
                    </button>

                    <button 
                        type="button"
                        wire:click="confirmBooking"
                        class="rounded-lg bg-tactical-steel px-6 py-2.5 text-xs font-mono font-bold text-surface-base hover:bg-sky-300 transition shadow-lg disabled:opacity-40 disabled:cursor-not-allowed"
                        {{ empty($selectedSlot) ? 'disabled' : '' }}
                    >
                        Confirm Booking ➔
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>