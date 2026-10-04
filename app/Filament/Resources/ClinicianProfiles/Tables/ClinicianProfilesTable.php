<?php

namespace App\Filament\Resources\ClinicianProfiles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClinicianProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('professional_title')
                    ->searchable(),
                TextColumn::make('licensing_state_or_jurisdiction')
                    ->searchable(),
                TextColumn::make('license_verified_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('hourly_rate_cents')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('max_weekly_caseload')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_accepting_clients')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
