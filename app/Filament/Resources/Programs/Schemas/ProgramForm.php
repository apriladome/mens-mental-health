<?php

namespace App\Filament\Resources\Programs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('summary')
                    ->required()
                    ->columnSpanFull(),
                Select::make('tier_requirement')
                    ->options(['free' => 'Free', 'member' => 'Member', 'premium' => 'Premium'])
                    ->default('free')
                    ->required(),
                TextInput::make('estimated_completion_days')
                    ->required()
                    ->numeric()
                    ->default(7),
                Toggle::make('is_published')
                    ->required(),
            ]);
    }
}
