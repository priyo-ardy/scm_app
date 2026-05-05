<?php

namespace App\Filament\Resources\ApprovalLogs;

use App\Filament\Resources\ApprovalLogs\Pages\CreateApprovalLog;
use App\Filament\Resources\ApprovalLogs\Pages\EditApprovalLog;
use App\Filament\Resources\ApprovalLogs\Pages\ListApprovalLogs;
use App\Filament\Resources\ApprovalLogs\Pages\ViewApprovalLog;
use App\Filament\Resources\ApprovalLogs\Schemas\ApprovalLogForm;
use App\Filament\Resources\ApprovalLogs\Schemas\ApprovalLogInfolist;
use App\Filament\Resources\ApprovalLogs\Tables\ApprovalLogsTable;
use App\Models\ApprovalLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ApprovalLogResource extends Resource
{
    protected static ?string $model = ApprovalLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'ApprovalLog';

    public static function form(Schema $schema): Schema
    {
        return ApprovalLogForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ApprovalLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApprovalLogsTable::configure($table);
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
            'index' => ListApprovalLogs::route('/'),
            'create' => CreateApprovalLog::route('/create'),
            'view' => ViewApprovalLog::route('/{record}'),
            'edit' => EditApprovalLog::route('/{record}/edit'),
        ];
    }
}
