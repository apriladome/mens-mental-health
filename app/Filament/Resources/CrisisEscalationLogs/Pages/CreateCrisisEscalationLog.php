<?php

namespace App\Filament\Resources\CrisisEscalationLogs\Pages;

use App\Filament\Resources\CrisisEscalationLogs\CrisisEscalationLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCrisisEscalationLog extends CreateRecord
{
    protected static string $resource = CrisisEscalationLogResource::class;
}
