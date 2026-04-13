<?php

namespace App\Filament\Resources\Equipments\Tables;

use App\Filament\Exports\EquipmentExporter;
use App\Models\Branch;
use App\Models\Company;
use App\Models\EquipmentCategory;
use App\Models\Tonnage;
use App\Models\Workshop;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;

class EquipmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('companyList.name')
                    ->label('Company')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('branchList.name')
                    ->label('Branch')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('specification')
                    ->label('Specification')
                    ->sortable()
                    ->sortable(),
                TextColumn::make('equipment_no')
                    ->label('Machine No.')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('workshopList.name')
                    ->label('Workshop')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tonnageList.name')
                    ->label('Tonnage')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('brand')
                    ->label('Brand')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('model_number')
                    ->label('Model Number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('serial_number')
                    ->label('Serial No.')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('machine_rate')
                    ->label('Machine Rate')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('purchase_date')
                    ->date("d-M-Y")
                    ->label('Purchase Date')
                    ->sortable(),
                TextColumn::make('installation_date')
                    ->label('Installation Date')
                    ->date("d-M-Y")
                    ->sortable(),
                TextColumn::make('last_maintenance')
                    ->label('Last Maintenance Date')
                    ->date("d-M-Y")
                    ->sortable(),
                TextColumn::make('total_shots')
                    ->label('Total Shots')
                    ->sortable()
                    ->alignRight(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'standby' => 'Standby',
                        'running' => 'Running',
                        'breakdown' => 'Breakdown',
                        'repair' => 'Repair',
                        default => ucfirst($state), // Fallback kalau ada data lain
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'standby' => 'info',      // Biru: Sedang bersiap/menunggu
                        'running' => 'success',   // Hijau: Aman dan beroperasi normal
                        'breakdown' => 'danger',  // Merah: Rusak parah/berhenti beroperasi
                        'repair' => 'warning',    // Kuning/Oranye: Sedang dalam perbaikan
                        default => 'gray',        // Abu-abu: Default
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'standby' => 'heroicon-m-pause-circle',
                        'running' => 'heroicon-m-play-circle',
                        'breakdown' => 'heroicon-m-exclamation-triangle',
                        'repair' => 'heroicon-m-wrench-screwdriver',
                        default => 'heroicon-m-question-mark-circle',
                    }),
                TextColumn::make('description')
                    ->label('Remark')
                    ->searchable()
                    ->sortable()
            ])
            ->filters([
                Filter::make('equipment_filter')
                    ->schema([
                        Section::make()
                            ->schema([
                                Select::make('company_id')
                                    ->label('Company')
                                    ->relationship('companyList', 'name')
                                    ->native(false)
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set) => $set('branch_id', null))
                                    ->searchable()
                                    ->columnSpan(5),
                                Select::make('branch_id')
                                    ->label('Branch')
                                    ->relationship('branchList', 'name', modifyQueryUsing: fn(Builder $query, Get $get) => $query->where('company_id', $get('company_id')))
                                    ->native(false)
                                    ->preload()
                                    ->live()
                                    ->searchable()
                                    ->columnSpan(4)
                            ])
                            ->columns(12)
                            ->columnSpanFull(),
                        Section::make()
                            ->schema([
                                Select::make('category_id')
                                    ->label('Machine/Equipment Category')
                                    ->relationship('category', 'name')
                                    ->multiple()
                                    ->native(false)
                                    ->preload()
                                    ->searchable()
                                    ->columnSpan(3),
                                TextInput::make('code')
                                    ->label('Code')
                                    ->placeholder('Search with code')
                                    ->dehydrated()
                                    ->columnSpan(2),
                                TextInput::make('name')
                                    ->label('Name')
                                    ->maxLength(150)
                                    ->placeholder("Equipment/Machine Name")
                                    ->autocomplete(false)
                                    ->columnSpan(7),
                                Textarea::make('specification')
                                    ->label('Specification')
                                    ->placeholder('Equipment/Machine Specification')
                                    ->columnSpanFull()
                                    ->autocomplete(false)
                                    ->rows(5),
                                TextInput::make('equipment_no')
                                    ->label('Machine/Equipment No.')
                                    ->nullable()
                                    ->placeholder('Machine/Equipment No.')
                                    ->columnSpan(3)
                                    ->autocomplete(false),
                                Select::make('workshop_id')
                                    ->label('Workshop')
                                    ->relationship('workshopList', 'name', modifyQueryUsing: fn(Builder $query, Get $get) => $query->where('branch_id', $get('branch_id')))
                                    ->native(false)
                                    ->multiple()
                                    ->preload()
                                    ->searchable()
                                    ->columnSpan(3),
                                Select::make('tonnage_id')
                                    ->label('Tonnage')
                                    ->relationship('tonnageList', 'name')
                                    ->native(false)
                                    ->preload()
                                    ->nullable()
                                    ->columnSpan(3)
                                    ->searchable(),
                                TextInput::make('brand')
                                    ->label('Equipment/Machine Brand')
                                    ->placeholder('Equipment/Machine Brand')
                                    ->columnSpan(3)
                                    ->autocomplete(false),
                                TextInput::make('model_number')
                                    ->label('Model Number')
                                    ->maxLength(50)
                                    ->placeholder('Model Number')
                                    ->autocomplete(false)
                                    ->columnSpan(3),
                                TextInput::make('serial_number')
                                    ->label('Serial No.')
                                    ->placeholder('Serial No')
                                    ->maxLength(50)
                                    ->autocomplete(false)
                                    ->columnSpan(3),
                                TextInput::make('machine_rate')
                                    ->label('Machine/Equipment Rate')
                                    ->placeholder('Machine/Equipment Rate')
                                    ->autocomplete(false)
                                    ->columnSpan(3),
                                Select::make('status')
                                    ->label('Machine/Equipment Status')
                                    ->options([
                                        'standby' => 'Standby',
                                        'running' => 'Running',
                                        'breakdown' => 'Breakdown',
                                        'repair' => "Repair"
                                    ])
                                    ->searchable()
                                    ->native(false)
                                    ->columnSpan(3),
                                Textarea::make('description')
                                    ->label('Description')
                                    ->placeholder('Additional information here')
                                    ->rows(3)
                                    ->columnSpanFull()
                            ])
                            ->columns(12)
                            ->columnSpanFull()
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['company_id'],
                                fn(Builder $query, $company_id): Builder => $query->where('company_id', "$company_id")
                            )
                            ->when(
                                $data['branch_id'],
                                fn(Builder $query, $branch_id): Builder => $query->where('branch_id', "$branch_id")
                            )
                            ->when(
                                $data['category_id'],
                                fn(Builder $query, $category_ids): Builder => $query->whereIn('category_id', $category_ids)
                            )
                            ->when(
                                $data['code'],
                                fn(Builder $query, $code): Builder => $query->where('code', 'LIKE', "%$code%")
                            )
                            ->when(
                                $data['name'],
                                fn(Builder $query, $name): Builder => $query->where('name', 'LIKE', "%$name%")
                            )
                            ->when(
                                $data['specification'],
                                fn(Builder $query, $specification): Builder => $query->where('specification', 'LIKE', "%$specification%")
                            )
                            ->when(
                                $data['equipment_no'],
                                fn(Builder $query, $equipment_no): Builder => $query->where('equipment_no', 'LIKE', "%$equipment_no%")
                            )
                            ->when(
                                $data['workshop_id'],
                                fn(Builder $query, $workshop_ids): Builder => $query->whereIn('workshop_id', $workshop_ids),
                            )
                            ->when(
                                $data['tonnage_id'],
                                fn(Builder $query, $tonnage_id): Builder => $query->where('tonnage_id', "$tonnage_id")
                            )
                            ->when(
                                $data['brand'],
                                fn(Builder $query, $brand): Builder => $query->where('brand', 'LIKE', "%$brand%")
                            )
                            ->when(
                                $data['model_number'],
                                fn(Builder $query, $model_number): Builder => $query->where('model_number', 'LIKE', "%$model_number%")
                            )
                            ->when(
                                $data['serial_number'],
                                fn(Builder $query, $serial_number): Builder => $query->where('serial_number', 'LIKE', "%$serial_number%")
                            )
                            ->when(
                                $data['machine_rate'],
                                fn(Builder $query, $machine_rate): Builder => $query->where('machine_rate', 'LIKE', "%$machine_rate%")
                            )
                            ->when(
                                $data['status'],
                                fn(Builder $query, $status): Builder => $query->where('status', "$status")
                            )
                            ->when(
                                $data['description'],
                                fn(Builder $query, $description): Builder => $query->where('description', 'LIKE', "%$description%")
                            )
                        ;
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['company_id'] ?? null) {
                            $companyName = Company::find($data['company_id'])?->name;
                            $indicators[] = 'Company: ' . ($companyName ?? $data['company_id']);
                        }

                        if ($data['branch_id'] ?? null) {
                            $branchName = Branch::find($data['branch_id'])?->name;
                            $indicators[] = 'Branch: ' . ($branchName ?? $data['branch_id']);
                        }

                        if ($data['category_id'] ?? null) {
                            $categoryNames = EquipmentCategory::whereIn('id', $data['category_id'])->pluck('name')->implode(', ');
                            $indicators[] = 'Category: ' . $categoryNames;
                        }

                        if ($data['code'] ?? null) {
                            $indicators[] = 'Code: ' . $data['code'];
                        }

                        if ($data['name'] ?? null) {
                            $indicators[] = 'Name: ' . $data['name'];
                        }

                        if ($data['specification'] ?? null) {
                            $indicators[] = 'Specification: ' . $data['specification'];
                        }

                        if ($data['equipment_no'] ?? null) {
                            $indicators[] =  'Equipment No.: ' . $data['equipment_no'];
                        }

                        if ($data['workshop_id'] ?? null) {
                            // $workshopName = Workshop::find($data['workshop_id'])?->name;
                            $workshopName = Workshop::whereIn('id', $data['workshop_id'])->pluck('name')->implode(', ');
                            $indicators[] = 'Workshop: ' . $workshopName;
                        }

                        if ($data['tonnage_id'] ?? null) {
                            $tonnageName = Tonnage::find($data['tonnage_id'])?->name;
                            $indicators[] = 'Tonnage: ' . ($tonnageName ?? $data['tonnage_id']);
                        }

                        if ($data['brand'] ?? null) {
                            $indicators[] = 'Brand: ' . $data['brand'];
                        }

                        if ($data['model_number'] ?? null) {
                            $indicators[] = 'Model No.: ' . $data['model_number'];
                        }

                        if ($data['serial_number'] ?? null) {
                            $indicators[] = 'Serial No.: ' . $data['serial_number'];
                        }

                        if ($data['status'] ?? null) {
                            $indicators[] = 'Status: ' . $data['status'];
                        }

                        if ($data['machine_rate'] ?? null) {
                            $indicators[] = 'Machine Rate: ' . $data['machine_rate'];
                        }

                        if ($data['description'] ?? null) {
                            $indicators[] = 'Description: ' . $data['description'];
                        }

                        return $indicators;
                    }),
            ])
            ->filtersLayout(FiltersLayout::Modal)
            ->filtersFormWidth('5xl')
            ->filtersTriggerAction(
                fn($action) => $action
                    ->button()
                    ->label('Filter')
                    ->icon(Heroicon::OutlinedFunnel)
            )
            ->recordActions([
                EditAction::make(),
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
                    ->exporter(EquipmentExporter::class)
                // ->columnMapping(false)
            ]);
    }
}
