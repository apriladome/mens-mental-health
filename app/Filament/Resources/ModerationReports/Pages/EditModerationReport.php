<?php

namespace App\Filament\Resources\ModerationReports\Pages;

use App\Filament\Resources\ModerationReports\ModerationReportResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditModerationReport extends EditRecord
{
    protected static string $resource = ModerationReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
