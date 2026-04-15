<?php

namespace App\Filament\Resources\TimeZones;

use App\Filament\Resources\TimeZones\Pages\CreateTimeZone;
use App\Filament\Resources\TimeZones\Pages\EditTimeZone;
use App\Filament\Resources\TimeZones\Pages\ListTimeZones;
use App\Filament\Resources\TimeZones\Schemas\TimeZoneForm;
use App\Filament\Resources\TimeZones\Tables\TimeZonesTable;
use App\Models\TimeZone;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class TimeZoneResource extends Resource
{
    protected static ?string $model = TimeZone::class;

    protected static string|UnitEnum|null $navigationGroup = 'Application Setup';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::GlobeAlt;

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'Time Zones';

    public static function form(Schema $schema): Schema
    {
        return TimeZoneForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TimeZonesTable::configure($table);
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
            'index' => ListTimeZones::route('/'),
            'create' => CreateTimeZone::route('/create'),
            'edit' => EditTimeZone::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
