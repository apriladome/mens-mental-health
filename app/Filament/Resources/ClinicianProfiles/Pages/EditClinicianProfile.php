<?php

namespace App\Filament\Resources\ClinicianProfiles\Pages;

use App\Filament\Resources\ClinicianProfiles\ClinicianProfileResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditClinicianProfile extends EditRecord
{
    protected static string $resource = ClinicianProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
