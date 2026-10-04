<?php

namespace App\Filament\Resources\ModerationReports;

use App\Filament\Resources\ModerationReports\Pages\CreateModerationReport;
use App\Filament\Resources\ModerationReports\Pages\EditModerationReport;
use App\Filament\Resources\ModerationReports\Pages\ListModerationReports;
use App\Filament\Resources\ModerationReports\Schemas\ModerationReportForm;
use App\Filament\Resources\ModerationReports\Tables\ModerationReportsTable;
use App\Models\ModerationReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ModerationReportResource extends Resource
{
    protected static ?string $model = ModerationReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldExclamation;

    protected static ?string $recordTitleAttribute = 'reason';

    public static function getNavigationGroup(): ?string
    {
        return 'Community & Moderation';
    }

    public static function getNavigationBadge(): ?string
    {
        $pendingCount = ModerationReport::where('status', 'pending')->count();

        return $pendingCount > 0 ? (string) $pendingCount : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function canViewAny(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        return $user && $user->hasAnyRole(['super_admin', 'moderator']);
    }

    public static function form(Schema $schema): Schema
    {
        return ModerationReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ModerationReportsTable::configure($table);
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
            'index' => ListModerationReports::route('/'),
            'create' => CreateModerationReport::route('/create'),
            'edit' => EditModerationReport::route('/{record}/edit'),
        ];
    }
}