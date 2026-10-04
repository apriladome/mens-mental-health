<?php

namespace App\Filament\Resources\CrisisEscalationLogs\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CrisisEscalationLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'id')
                    ->required(),
                Select::make('trigger_source')
                    ->options([
            'phq9_q9' => 'Phq9 q9',
            'keyword_sentinel' => 'Keyword sentinel',
            'manual_panic_trigger' => 'Manual panic trigger',
            'provider_flag' => 'Provider flag',
        ])
                    ->required(),
                Select::make('severity_level')
                    ->options(['elevated' => 'Elevated', 'imminent_danger' => 'Imminent danger'])
                    ->required(),
                Toggle::make('intercept_viewed')
                    ->required(),
                Select::make('clinician_dispatched_id')
                    ->relationship('clinicianDispatched', 'id')
                    ->default(null),
                DateTimePicker::make('resolved_at'),
                Textarea::make('resolution_notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
