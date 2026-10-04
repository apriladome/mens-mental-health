<?php

namespace App\Filament\Resources\CrisisEscalationLogs\Pages;

use App\Filament\Resources\CrisisEscalationLogs\CrisisEscalationLogResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCrisisEscalationLog extends EditRecord
{
    protected static string $resource = CrisisEscalationLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
