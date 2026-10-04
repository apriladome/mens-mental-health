<?php

namespace App\Filament\Resources\CrisisEscalationLogs;

use App\Filament\Resources\CrisisEscalationLogs\Pages\CreateCrisisEscalationLog;
use App\Filament\Resources\CrisisEscalationLogs\Pages\EditCrisisEscalationLog;
use App\Filament\Resources\CrisisEscalationLogs\Pages\ListCrisisEscalationLogs;
use App\Filament\Resources\CrisisEscalationLogs\Schemas\CrisisEscalationLogForm;
use App\Filament\Resources\CrisisEscalationLogs\Tables\CrisisEscalationLogsTable;
use App\Models\CrisisEscalationLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class CrisisEscalationLogResource extends Resource
{
    protected static ?string $model = CrisisEscalationLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;

    protected static ?string $recordTitleAttribute = 'severity_level';

    /**
     * Group this resource in the sidebar.
     */
    public static function getNavigationGroup(): ?string
    {
        return 'Safety & Clinical Operations';
    }

    /**
     * Show a real-time badge count of active unresolved crisis incidents.
     */
    public static function getNavigationBadge(): ?string
    {
        $unresolvedCount = CrisisEscalationLog::whereNull('resolved_at')->count();

        return $unresolvedCount > 0 ? (string) $unresolvedCount : null;
    }

    /**
     * Display the badge in urgent red.
     */
    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    /**
     * Restrict access strictly to Clinical Directors, Clinicians, and Super Admins.
     */
    public static function canViewAny(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        return $user && $user->hasAnyRole(['super_admin', 'clinical_director', 'clinician']);
    }

    public static function form(Schema $schema): Schema
    {
        return CrisisEscalationLogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CrisisEscalationLogsTable::configure($table);
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
            'index' => ListCrisisEscalationLogs::route('/'),
            'create' => CreateCrisisEscalationLog::route('/create'),
            'edit' => EditCrisisEscalationLog::route('/{record}/edit'),
        ];
    }
}