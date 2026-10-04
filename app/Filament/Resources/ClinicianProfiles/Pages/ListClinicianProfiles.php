<?php

namespace App\Filament\Resources\ClinicianProfiles\Pages;

use App\Filament\Resources\ClinicianProfiles\ClinicianProfileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClinicianProfiles extends ListRecords
{
    protected static string $resource = ClinicianProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
