<?php

namespace App\Filament\Resources\TimeZones\Tables;

use App\Filament\Exports\TimeZonesExporter;
use App\Filament\Imports\TimeZonesImporter;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\ImportAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TimeZonesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('offset')
                    ->label('Offset')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->sortable()
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                Filter::make('name')
                    ->label('Name')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->placeholder('Enter timezone name'),
                        TextInput::make('offset')
                            ->label('Offset')
                            ->placeholder('Enter timezone offset'),
                        TextInput::make('description')
                            ->label('Description')
                            ->placeholder('Enter timezone description'),
                    ])->query(function ($query, array $data) {
                        return $query
                            ->when($data['name'], fn($query, $name) => $query->where('name', 'like', "%{$name}%"))
                            ->when($data['offset'], fn($query, $offset) => $query->where('offset', 'like', "%{$offset}%"))
                            ->when($data['description'], fn($query, $description) => $query->where('description', 'like', "%{$description}%"));
                    }),
                Filter::make('is_active')
                    ->label('Active')
                    ->query(fn($query) => $query->where('is_active', true)),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
                Action::make('refresh')
                    ->label('Refresh')
                    ->icon('heroicon-o-arrow-path')
                    ->action(fn() => null),
                ExportAction::make()
                    ->exporter(TimeZonesExporter::class)
                    ->label('Export')
                    ->icon('heroicon-o-document-arrow-down'),
                ImportAction::make()
                    ->importer(TimeZonesImporter::class)
                    ->label('Import')
                    ->icon('heroicon-o-document-arrow-up'),
            ]);
    }
}
