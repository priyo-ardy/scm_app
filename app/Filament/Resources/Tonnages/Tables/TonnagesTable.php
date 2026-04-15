<?php

namespace App\Filament\Resources\Tonnages\Tables;

use App\Filament\Exports\TonnageExporter;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TonnagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Tonnage Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Tonnage Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('clamping_force_kn')
                    ->label('Clamping Force KN')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->suffix(' kN')
                    ->alignRight(),
                TextColumn::make('std_dbugging')
                    ->label('Standart Debugging')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->suffix(' Kg')
                    ->alignRight(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Active' : 'Deactive')
                    ->color(fn (bool $state): string => $state ? 'danger' : 'success')
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('remark')
                    ->label('Remark')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('filter')
                    ->columns(3)
                    ->schema([
                        TextInput::make('code')->label('Tonnage Code')->placeholder('Search with code ...')->autocomplete(false),
                        TextInput::make('name')->label('Tonnage Name')->placeholder('Search with name ...')->autocomplete(false),
                        TextInput::make('clamping_force_kn')->label('Clamping Force KN')->numeric()->placeholder('Search with clamping force ...')->autocomplete(false),
                        Select::make('is_active')->options(['0' => 'Deactive', '1' => 'Active'])->native()->searchable(),
                        TextInput::make('std_dbugging')->numeric()->placeholder('Search with debugging'),
                        Textarea::make('remark')->label('Remark')->placeholder('Search with remark')->autocomplete(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['code'],
                                fn (Builder $query, $code): Builder => $query->where('code', 'LIKE', "%$code%")
                            )
                            ->when(
                                $data['name'],
                                fn (Builder $query, $name): Builder => $query->where('name', 'LIKE', "%$name%")
                            )
                            ->when(
                                $data['clamping_force_kn'],
                                fn (Builder $query, $clamping_force_kn): Builder => $query->where('clamping_force_kn', 'LIKE', "%$clamping_force_kn%")
                            )
                            ->when(
                                $data['is_active'],
                                fn (Builder $query, $is_active): Builder => $query->where('is_active', "$is_active")
                            )
                            ->when(
                                $data['remark'],
                                fn (Builder $query, $remark): Builder => $query->where('remark', 'LIKE', "%$remark%")
                            )
                            ->when(
                                $data['std_dbugging'],
                                fn (Builder $query, $std_dbugging): Builder => $query->where('std_dbugging', 'LIKE', "%$std_dbugging%")
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['code'] ?? null) {
                            $indicators[] = 'Workshop Code: '.$data['code'];
                        }

                        if ($data['name'] ?? null) {
                            $indicators[] = 'Workshop Name: '.$data['name'];
                        }

                        if ($data['clamping_force_kn'] ?? null) {
                            $indicators[] = 'Clamping Force Kn: '.$data['clamping_force_kn'];
                        }

                        if ($data['is_active'] ?? null) {
                            $status = ($data['is_active'] == '1') ? 'Active' : 'Deactive';
                            $indicators[] = 'Status: '.($status ?? $data['is_active']);
                        }

                        if ($data['remark'] ?? null) {
                            $indicators[] = 'Remark: '.$data['remark'];
                        }

                        if ($data['std_dbugging'] ?? null) {
                            $indicators[] = 'Standart Debugging: '.$data['std_dbugging'];
                        }

                        return $indicators;
                    }),
            ])
            ->filtersLayout(FiltersLayout::Modal)
            ->filtersFormWidth('4xl')
            ->filtersTriggerAction(
                fn ($action) => $action
                    ->button()
                    ->label('Filter')
                    ->icon(Heroicon::Funnel)
            )
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
                Action::make('refresh')
                    ->label('Refresh')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->action(fn () => null),
                ExportAction::make('export')
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->exporter(TonnageExporter::class),
            ]);
    }
}
