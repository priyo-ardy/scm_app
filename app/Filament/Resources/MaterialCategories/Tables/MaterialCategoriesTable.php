<?php

namespace App\Filament\Resources\MaterialCategories\Tables;

use App\Filament\Exports\MaterialCategoryExporter;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use SebastianBergmann\Exporter\Exporter;

class MaterialCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Active' : 'deactive')
                    ->color(fn(bool $state): string => $state ? 'danger' : 'success')
                    ->alignCenter(),
            ])
            ->defaultSort('code', 'asc')
            ->filters([
                Filter::make('filter')
                    ->columns(3)
                    ->schema([
                        TextInput::make('name')->placeholder('Search with name ...')->autocomplete(false),
                        TextInput::make('prefix')->placeholder('Search with prefix ...')->autocomplete(false),
                        Select::make('is_active')->label('Status')->options(['0' => 'Deactive', '1' => "Active"])->native()->searchable()
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['name'],
                                fn(Builder $query, $name): Builder => $query->where('name', 'LIKE', "%$name%")
                            )
                            ->when(
                                $data['is_active'],
                                fn(Builder $query, $is_active): Builder => $query->where('is_active', "%$is_active%")
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['name'] ?? null) {
                            $indicators[] = 'Name: ' . $data['name'];
                        }

                        if ($data['is_active'] ?? null) {
                            $status = ($data['is_active'] == '1') ? 'Active' : 'Deactive';
                            $indicators[] = "Status: " . ($status ?? $data['is_active']);
                        }

                        return $indicators;
                    })
            ])
            ->filtersLayout(FiltersLayout::Modal)
            ->filtersFormWidth('4xl')
            ->filtersTriggerAction(
                fn($action) => $action
                    ->button()
                    ->label('Filter')
                    ->icon(Heroicon::Funnel)
            )
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
                Action::make('refresh')
                    ->label('Refresh')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->action(fn() => null),
                ExportAction::make('export')
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->exporter(MaterialCategoryExporter::class)
            ]);
    }
}
