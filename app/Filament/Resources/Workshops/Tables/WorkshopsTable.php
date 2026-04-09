<?php

namespace App\Filament\Resources\Workshops\Tables;

use App\Filament\Exports\WorkshopExporter;
use App\Models\Branch;
use App\Models\User;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WorkshopsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Workshop Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Workshop Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('branch.name')
                    ->label('Branch')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('location_detail')
                    ->label('Location Details')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Workshop PIC')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Workshop Ext. No.')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('remarks')
                    ->label('Remark')
                    ->searchable(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Active' : 'Disable')
                    ->color(fn(bool $state): string => $state ? 'danger' : 'success')
                    ->alignCenter()
            ])
            ->filters([
                Filter::make('filter')
                    ->columns(3)
                    ->schema([
                        TextInput::make('name')->label('Workshop Name')->placeholder('Search by workshop name ...')->autocomplete(false),
                        Select::make('branch_id')->label('Branch')->relationship('branch', 'name')->native()->preload()->searchable(),
                        TextInput::make('location_detail')->label('Location Details')->placeholder('Search by location details ...')->autocomplete(false),
                        Select::make('pic_id')->label('Workshop PIC')->relationship('user', 'name')->native()->preload()->searchable(),
                        Select::make('is_active')->label('Status')->options(['0' => 'Deactive', '1' => 'Active'])->native()->searchable()
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['name'],
                                fn(Builder $query, $name): Builder => $query->where('name', 'LIKE', "%$name%")
                            )
                            ->when(
                                $data['branch_id'],
                                fn(Builder $query, $branch_id): Builder => $query->where('branch_id', "$branch_id")
                            )
                            ->when(
                                $data['location_detail'],
                                fn(Builder $query, $location_detail): Builder => $query->where('location_detail', 'LIKE', "%$location_detail%")
                            )
                            ->when(
                                $data['pic_id'],
                                fn(Builder $query, $pic_id): Builder => $query->where('pic_id', "$pic_id")
                            )
                            ->when(
                                $data['is_active'],
                                fn(Builder $query, $is_active): Builder => $query->where('is_active', "$is_active")
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['name'] ?? null) {
                            $indicators[] = 'Workshop Name: ' . $data['name'];
                        }

                        if ($data['branch_id'] ?? null) {
                            $branchName = Branch::find($data['branch_id'])?->name;
                            $indicators[] = 'Branch: ' . ($branchName ?? $data['branch_id']);
                        }

                        if ($data['location_detail'] ?? null) {
                            $indicators[] = 'Location Details: ' . $data['location_detail'];
                        }

                        if ($data['pic_id'] ?? null) {
                            $picName = User::find($data['pic_id'])?->name;
                            $indicators[] = 'Workshop PIC: ' . ($picName ?? $data['pic_id']);
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
                ExportAction::make()
                    ->label('Export')
                    ->exporter(WorkshopExporter::class)
                    ->icon(Heroicon::OutlinedArrowDownTray)
            ]);
    }
}
