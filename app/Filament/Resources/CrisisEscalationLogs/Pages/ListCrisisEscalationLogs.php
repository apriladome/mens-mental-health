<?php

namespace App\Filament\Resources\CrisisEscalationLogs\Pages;

use App\Filament\Resources\CrisisEscalationLogs\CrisisEscalationLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCrisisEscalationLogs extends ListRecords
{
    protected static string $resource = CrisisEscalationLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
