<?php

namespace App\Filament\Resources\PurchaseRequisitions\Schemas;

use App\Models\Company;
use App\Models\Material;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;
use Illuminate\Database\Eloquent\Builder;

class PurchaseRequisitionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'name')
                            ->default(function () {
                                $sessionCompanyId = session('active_company');

                                if ($sessionCompanyId) {
                                    return $sessionCompanyId;
                                }

                                return Company::where('is_default', '=', 1, 'and')->first()?->id;
                            })
                            ->disabled(fn() => session('active_company') !== null)
                            ->dehydrated(true)
                            ->searchable()
                            ->native(false)
                            ->preload()
                            ->required()
                            ->columnSpan(4),
                        TextInput::make('code')
                            ->label('Code')
                            ->placeholder('Automatic generate after save')
                            ->readOnly()
                            ->columnSpan(3),
                        DatePicker::make('doc_date')
                            ->label('Date')
                            ->required()
                            ->default(now())
                            ->columnSpan(2),
                        Select::make('department_id')
                            ->label('Department')
                            ->default(session('department_id'))
                            ->disabled()
                            ->relationship('department', 'name', modifyQueryUsing: fn(Builder $query) => $query->where('is_active', true)->orderBy('name', 'asc'))
                            ->dehydrated(true)
                            ->searchable()
                            ->native(false)
                            ->preload()
                            ->required()
                            ->columnSpan(3),
                        Select::make('priority')
                            ->label('Priority')
                            ->options([
                                'normal' => 'Normal',
                                'urgent' => 'Urgent',
                                'critical' => 'Critical',
                            ])
                            ->searchable()
                            ->native(false)
                            ->preload()
                            ->required()
                            ->default('normal')
                            ->columnSpan(3),
                        Textarea::make('reason')
                            ->label('Reason')
                            ->placeholder('Write purchase requisition reason here ...')
                            ->columnSpan(9)
                            ->nullable()
                            ->rows(3),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
                Repeater::make('details')
                    ->extraAttributes(['class' => 'repeater-table-overflow'])
                    ->relationship()
                    ->table([
                        TableColumn::make('Material'),
                        TableColumn::make('Specification'),
                        TableColumn::make('UoM'),
                        TableColumn::make('Qty'),
                        TableColumn::make('Arrival Date'),
                        TableColumn::make('Suggest Supplier'),
                        TableColumn::make('Remark'),
                    ])
                    ->compact()
                    ->schema([
                        Select::make('material_id')
                            ->label('Material')
                            ->relationship('material', 'code', modifyQueryUsing: fn(Builder $query) => $query->where('status', 'active')->where('properties', 'service')->orderBy('code', 'asc'))
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                            ->searchable()
                            ->required()
                            ->native(false)
                            ->afterStateUpdated(function ($state, Set $set) {
                                if (! $state) {
                                    $set('unit_id', null);

                                    return;
                                }

                                $material = Material::find($state);

                                if ($material && $material->unit_id) {
                                    $set('specification', $material->specification);
                                    $set('unit_id', $material->unit_id);
                                }
                            })
                            ->afterStateHydrated(function ($state, Set $set) {
                                if ($state) {
                                    $material = Material::find($state);
                                    $set('material_name', $material?->name);
                                    $set('specification', $material?->specification);
                                }
                            })
                            ->live()
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                            ->preload(),
                        TextInput::make('specification')
                            ->label('Specification')
                            ->placeholder('Specification')
                            ->readonly(),
                        Select::make('unit_id')
                            ->label('UoM')
                            ->required()
                            ->relationship('units', 'code', modifyQueryUsing: fn(Builder $query) => $query->where('is_active', '=', true, 'and')->orderBy('code', 'asc'))
                            ->searchable()
                            ->native(false)
                            ->preload(),
                        TextInput::make('qty')
                            ->label('Qty')
                            ->mask(RawJs::make('$money($input)'))
                            ->dehydrateStateUsing(fn($state) => $state !== null ? (float) str_replace(',', '', $state) : 0)
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->default(1)
                            ->required(),
                        DatePicker::make('arrival_date')
                            ->label('Required Arrival Date')
                            ->default(now())
                            ->required(),
                        Select::make('supplier_id')
                            ->label('Default Supplier')
                            ->relationship('supplier', 'name', modifyQueryUsing: fn(Builder $query) => $query->where('is_active', '=', true, 'and')->orderBy('name', 'asc'))
                            ->searchable()
                            ->native(false)
                            ->preload(),
                        TextInput::make('remark')
                            ->label('Remark')
                            ->placeholder('Remark ...'),
                    ])
                    ->deleteAction(
                        fn(Action $action) => $action->requiresConfirmation()
                    )
                    ->columnSpanFull(),
            ]);
    }
}
