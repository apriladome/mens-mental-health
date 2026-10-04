<?php

namespace App\Filament\Resources\ModerationReports\Pages;

use App\Filament\Resources\ModerationReports\ModerationReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListModerationReports extends ListRecords
{
    protected static string $resource = ModerationReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
