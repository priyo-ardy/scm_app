<?php

namespace App\Filament\Resources\Currencies\Tables;

use App\Filament\Exports\CurrencyExporter;
use Dom\Text;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CurrenciesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('symbol')
                    ->searchable(),
                TextColumn::make('decimal_digits')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make()
                    ->schema([
                        TextInput::make('code')
                            ->label('Code')
                            ->placeholder('Enter currency code'),
                        TextInput::make('name')
                            ->label('Name')
                            ->placeholder('Enter currency name'),
                        DatePicker::make('created_from')
                            ->label("Created From"),
                        DatePicker::make('created_until')
                            ->label("Created Until"),
                    ])->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['code'], fn(Builder $query, $code) => $query->where('code', 'like', "%{$code}%"))
                            ->when($data['name'], fn(Builder $query, $name) => $query->where('name', 'like', "%{$name}%"))
                            ->when($data['created_from'], fn(Builder $query, $date) => $query->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn(Builder $query, $date) => $query->whereDate('created_at', '<=', $date));
                    }),
                Filter::make('is_active')
                    ->label('Active')
                    ->query(fn($query) => $query->where('is_active', true)),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
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
                    ->exporter(CurrencyExporter::class)
                    ->label('Export')
                    ->icon('heroicon-o-document-arrow-down'),
            ]);
    }
}
