<?php

namespace App\Filament\Resources\ModerationReports\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ModerationReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('reporter_user_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('reportable_type')
                    ->required(),
                TextInput::make('reportable_id')
                    ->required()
                    ->numeric(),
                Select::make('reason')
                    ->options([
            'self_harm_risk' => 'Self harm risk',
            'hate_speech' => 'Hate speech',
            'harassment' => 'Harassment',
            'spam' => 'Spam',
            'other' => 'Other',
        ])
                    ->required(),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'reviewed' => 'Reviewed',
            'dismissed' => 'Dismissed',
            'actioned' => 'Actioned',
        ])
                    ->default('pending')
                    ->required(),
            ]);
    }
}
