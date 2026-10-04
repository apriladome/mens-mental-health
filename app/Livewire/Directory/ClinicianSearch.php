<?php

declare(strict_types=1);

namespace App\Livewire\Directory;

use App\Models\ClinicianProfile;
use App\Models\Specialty;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class ClinicianSearch extends Component
{
    public string $search = '';
    public string $selectedSpecialty = '';
    public string $selectedJurisdiction = '';

    public ?int $bookingClinicianId = null;

    public Collection $specialties;

    public function mount(): void
    {
        $this->specialties = Specialty::orderBy('name', 'asc')->get();
    }

    public function openBooking(int $clinicianId): void
    {
        $this->bookingClinicianId = $clinicianId;
    }

    /**
     * Listens for the close event dispatched from the child BookingModal component.
     */
    #[On('close-booking-modal')]
    public function closeBooking(): void
    {
        $this->bookingClinicianId = null;
    }

    public function render(): View
    {
        $query = ClinicianProfile::where('is_accepting_clients', true)
            ->whereNotNull('license_verified_at')
            ->with(['specialties', 'user.profile']);

        if (!empty($this->search)) {
            $term = '%' . strtolower(trim($this->search)) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('professional_title', 'like', $term)
                  ->orWhere('bio_summary', 'like', $term);
            });
        }

        if (!empty($this->selectedJurisdiction)) {
            $query->where('licensing_state_or_jurisdiction', $this->selectedJurisdiction);
        }

        if (!empty($this->selectedSpecialty)) {
            $query->whereHas('specialties', function ($q) {
                $q->where('specialties.slug', $this->selectedSpecialty);
            });
        }

        $clinicians = $query->get();

        $jurisdictions = ClinicianProfile::whereNotNull('license_verified_at')
            ->distinct()
            ->pluck('licensing_state_or_jurisdiction');

        return view('livewire.directory.clinician-search', [
            'clinicians' => $clinicians,
            'jurisdictions' => $jurisdictions,
        ]);
    }
}