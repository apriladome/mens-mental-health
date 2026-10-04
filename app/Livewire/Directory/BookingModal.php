<?php

declare(strict_types=1);

namespace App\Livewire\Directory;

use App\Actions\Telehealth\BookAppointmentAction;
use App\Models\Appointment;
use App\Models\ClinicianProfile;
use App\Models\User;
use App\Services\ClinicianScheduleManager;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class BookingModal extends Component
{
    public int $clinicianId;
    public ?ClinicianProfile $clinician = null;

    public string $selectedDate;
    public Collection $availableSlots;
    public ?string $selectedSlot = null;

    public ?Appointment $confirmedAppointment = null;
    public ?string $errorMessage = null;

    public function mount(int $clinicianId, ClinicianScheduleManager $scheduleManager): void
    {
        $this->clinicianId = $clinicianId;
        $this->clinician = ClinicianProfile::with(['specialties', 'user.profile'])->findOrFail($clinicianId);

        // Default to tomorrow or next business day
        $this->selectedDate = Carbon::tomorrow()->toDateString();
        $this->loadSlots($scheduleManager);
    }

    public function updatedSelectedDate(ClinicianScheduleManager $scheduleManager): void
    {
        $this->selectedSlot = null;
        $this->errorMessage = null;
        $this->loadSlots($scheduleManager);
    }

    public function loadSlots(ClinicianScheduleManager $scheduleManager): void
    {
        $date = Carbon::parse($this->selectedDate);
        $this->availableSlots = $scheduleManager->getAvailableSlots($this->clinician, $date);
    }

    public function selectSlot(string $slotStartTime): void
    {
        $this->selectedSlot = $slotStartTime;
        $this->errorMessage = null;
    }

    public function confirmBooking(BookAppointmentAction $bookAction, ClinicianScheduleManager $scheduleManager): void
    {
        if (!$this->selectedSlot) {
            $this->errorMessage = 'Please select an open consultation slot.';
            return;
        }

        /** @var User $user */
        $user = Auth::user();

        try {
            $startTime = Carbon::parse($this->selectedSlot);
            $this->confirmedAppointment = $bookAction->execute($user, $this->clinician, $startTime);
            $this->errorMessage = null;
        } catch (ValidationException $e) {
            $this->errorMessage = $e->validator->errors()->first();
            $this->loadSlots($scheduleManager); // Refresh slots if taken
        }
    }

    public function close(): void
    {
        $this->dispatch('close-booking-modal');
    }

    public function render(): View
    {
        return view('livewire.directory.booking-modal');
    }
}