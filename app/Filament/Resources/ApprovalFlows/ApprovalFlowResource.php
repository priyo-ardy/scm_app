<?php

namespace App\Filament\Resources\ApprovalFlows;

use App\Filament\Resources\ApprovalFlows\Pages\CreateApprovalFlow;
use App\Filament\Resources\ApprovalFlows\Pages\EditApprovalFlow;
use App\Filament\Resources\ApprovalFlows\Pages\ListApprovalFlows;
use App\Filament\Resources\ApprovalFlows\Schemas\ApprovalFlowForm;
use App\Filament\Resources\ApprovalFlows\Tables\ApprovalFlowsTable;
use App\Models\ApprovalFlow;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ApprovalFlowResource extends Resource
{
    protected static ?string $model = ApprovalFlow::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCommandLine;
    protected static string|UnitEnum|null $navigationGroup = 'Application Setup';
    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'Approval Flow';

    public static function form(Schema $schema): Schema
    {
        return ApprovalFlowForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApprovalFlowsTable::configure($table);
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
            'index' => ListApprovalFlows::route('/'),
            'create' => CreateApprovalFlow::route('/create'),
            'edit' => EditApprovalFlow::route('/{record}/edit'),
        ];
    }
}
