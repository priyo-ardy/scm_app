<?php

namespace App\Filament\Resources\Sections\Tables;

use App\Filament\Exports\SectionExporter;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\QueryBuilder\Constraints\SelectConstraint;
use Filament\QueryBuilder\Constraints\TextConstraint;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class SectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('companyList.slug')
                    ->label('Company')
                    ->searchable(['code', 'name', 'slug'])
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('code')
                    ->label('Section Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Section Name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('dept.name')
                    ->label('Department')
                    ->searchable(['code', 'name'])
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('sectionHead.name')
                    ->label('Section Head')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Enable' : 'Disable')
                    ->toggleable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('code')
                            ->label('Section Code'),
                        TextConstraint::make('name')
                            ->label('Section Name'),
                        TextConstraint::make('description')
                            ->label('Description'),
                        SelectConstraint::make('company_id')
                            ->label('Company')
                            ->options(fn () => Company::pluck('name', 'id'))
                            ->searchable()
                            ->native(false),
                        SelectConstraint::make('department_id')
                            ->label('Department')
                            ->options(fn () => Department::where('is_active', '=', true, 'and')->orderBy('name', 'asc')->pluck('name', 'id'))
                            ->searchable()
                            ->native(false),
                        SelectConstraint::make('section_head_id')
                            ->label('Section Head')
                            ->options(fn () => User::where('is_active', '=', true, 'and')->orderBy('name', 'asc')->pluck('name', 'id'))
                            ->searchable()
                            ->native(false),
                        SelectConstraint::make('is_active')
                            ->label('Status')
                            ->options([
                                '0' => 'Disable',
                                '1' => 'Enable',
                            ])
                            ->searchable()
                            ->native(false),
                    ])
                    ->constraintPickerColumns(2),
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth('4xl')
            ->filtersFormColumns(1)
            ->persistFiltersInSession()
            ->recordActions([
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    BulkAction::make('massEdit')
                        ->label('Mass Edit')
                        ->color('warning')
                        ->icon(Heroicon::OutlinedPencilSquare)
                        ->schema([
                            Grid::make(3)
                                ->schema([
                                    Select::make('column_to_update')
                                        ->label('Field to update')
                                        ->options([
                                            'company_id' => 'Company',
                                            'department_id' => 'Department',
                                            'section_head_id' => 'Section Head',
                                            'is_active' => 'Status',
                                            'description' => 'Description',
                                        ])
                                        ->searchable()
                                        ->live()
                                        ->columnSpan(1),
                                    Select::make('value_company_id')
                                        ->label('Company')
                                        ->options(fn () => Company::orderBy('name', 'asc')->pluck('name', 'id'))
                                        ->searchable()
                                        ->required()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'company_id')
                                        ->columnSpan(2),
                                    Select::make('value_department_id')
                                        ->label('Department')
                                        ->options(fn () => Department::where('is_active', '=', true, 'and')->orderBy('name', 'asc')->pluck('name', 'id'))
                                        ->searchable()
                                        ->required()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'department_id')
                                        ->columnSpan(2),
                                    Select::make('value_section_head_id')
                                        ->label('Section Head')
                                        ->options(fn () => User::where('is_active', '=', true, 'and')->orderBy('name', 'asc')->pluck('name', 'id'))
                                        ->searchable()
                                        ->required()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'section_head_id')
                                        ->columnSpan(2),
                                    Select::make('value_is_active')
                                        ->label('Section Head')
                                        ->options([
                                            '0' => 'Disable',
                                            '1' => 'Enable',
                                        ])
                                        ->searchable()
                                        ->required()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'is_active')
                                        ->columnSpan(2),
                                    TextInput::make('description')
                                        ->label('Description')
                                        ->placeholder('Edit description')
                                        ->columnSpan(2),
                                ]),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $column = $data['column_to_update'];

                            $newValue = match (true) {
                                ($column === 'company_id') => $data['value_company_id'],
                                ($column === 'department_id') => $data['value_department_id'],
                                ($column === 'section_head_id') => $data['value_section_head_id'],
                                ($column === 'is_active') => $data['value_is_active'],
                                ($column === 'description') => $data['value_description'],
                            };

                            $records->each->update([$column => $newValue]);

                            Notification::make()
                                ->title('Mass edit success')
                                ->body(count($records)." Records updated on field: {$column}")
                                ->success()
                                ->send();
                        }),
                ]),
                Action::make('refresh')
                    ->label('Refresh')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->tooltip('Refresh')
                    ->action(fn () => null),
                ExportAction::make('export')
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->exporter(SectionExporter::class)
                    ->tooltip('Export'),
            ]);
    }
}
