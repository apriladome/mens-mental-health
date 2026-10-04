<?php

namespace App\Filament\Resources\ClinicianProfiles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ClinicianProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Textarea::make('legal_name')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('professional_title')
                    ->required(),
                Textarea::make('bio_summary')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('license_number')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('licensing_state_or_jurisdiction')
                    ->required(),
                DateTimePicker::make('license_verified_at'),
                TextInput::make('hourly_rate_cents')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('max_weekly_caseload')
                    ->required()
                    ->numeric()
                    ->default(25),
                Toggle::make('is_accepting_clients')
                    ->required(),
            ]);
    }
}
