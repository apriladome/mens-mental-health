<x-app-layout>
    <div class="py-6 space-y-6">
        <!-- Top Row: Readiness Card (2 cols) & Keystone Habits (1 col) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <livewire:dashboard.daily-readiness-card />
            </div>
            <div>
                <livewire:habits.habit-checklist />
            </div>
        </div>

        <!-- Bottom Row: Encrypted CBT Cognitive Workbench -->
        <div>
            <livewire:journal.cbt-thought-record />
        </div>
    </div>
</x-app-layout>