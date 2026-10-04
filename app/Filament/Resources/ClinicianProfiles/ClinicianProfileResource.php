<?php

namespace App\Filament\Resources\ClinicianProfiles;

use App\Filament\Resources\ClinicianProfiles\Pages\CreateClinicianProfile;
use App\Filament\Resources\ClinicianProfiles\Pages\EditClinicianProfile;
use App\Filament\Resources\ClinicianProfiles\Pages\ListClinicianProfiles;
use App\Filament\Resources\ClinicianProfiles\Schemas\ClinicianProfileForm;
use App\Filament\Resources\ClinicianProfiles\Tables\ClinicianProfilesTable;
use App\Models\ClinicianProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ClinicianProfileResource extends Resource
{
    protected static ?string $model = ClinicianProfile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ClinicianProfileForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClinicianProfilesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClinicianProfiles::route('/'),
            'create' => CreateClinicianProfile::route('/create'),
            'edit' => EditClinicianProfile::route('/{record}/edit'),
        ];
    }
}
