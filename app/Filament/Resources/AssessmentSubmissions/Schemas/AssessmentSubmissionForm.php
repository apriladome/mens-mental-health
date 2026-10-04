<?php

namespace App\Filament\Resources\AssessmentSubmissions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AssessmentSubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('assessment_id')
                    ->required()
                    ->numeric(),
                TextInput::make('total_score')
                    ->required()
                    ->numeric(),
                Select::make('risk_classification')
                    ->options([
            'low' => 'Low',
            'mild' => 'Mild',
            'moderate' => 'Moderate',
            'severe' => 'Severe',
            'acute' => 'Acute',
        ])
                    ->required(),
                DateTimePicker::make('completed_at')
                    ->required(),
            ]);
    }
}
