<?php

declare(strict_types=1);

namespace App\Livewire\Journal;

use App\Actions\Tracking\StoreEncryptedJournalAction;
use App\Models\JournalEntry;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CbtThoughtRecord extends Component
{
    public string $triggerEvent = '';
    public string $automaticThought = '';
    public string $rationalReframe = '';

    public Collection $recentEntries;
    public bool $justSaved = false;

    public function mount(): void
    {
        $this->loadEntries();
    }

    public function loadEntries(): void
    {
        /** @var User $user */
        $user = Auth::user();

        // Eloquent automatically handles transparent AES-256 decryption via casts
        $this->recentEntries = JournalEntry::where('user_id', $user->id)
            ->where('template_type', 'cbt_thought_record')
            ->latest()
            ->take(5)
            ->get();
    }

    public function saveEntry(StoreEncryptedJournalAction $journalAction): void
    {
        $this->validate([
            'triggerEvent' => ['required', 'string', 'min:3', 'max:255'],
            'automaticThought' => ['required', 'string', 'min:3'],
            'rationalReframe' => ['required', 'string', 'min:3'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        $bodyContent = "TRIGGER / SITUATION:\n" . trim($this->triggerEvent) . "\n\n"
            . "AUTOMATIC DISTORTION:\n" . trim($this->automaticThought) . "\n\n"
            . "OBJECTIVE REFRAME:\n" . trim($this->rationalReframe);

        $journalAction->execute($user, [
            'template_type' => 'cbt_thought_record',
            'title' => trim($this->triggerEvent),
            'body' => $bodyContent,
            'sentiment_heuristic' => 'reframed',
        ]);

        $this->reset(['triggerEvent', 'automaticThought', 'rationalReframe']);
        $this->justSaved = true;
        $this->loadEntries();
    }

    public function render(): View
    {
        return view('livewire.journal.cbt-thought-record');
    }
}