<?php

namespace App\Filament\Resources\PurchaseRequisitions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

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
                            // ->relationship('')
                            ->searchable()
                            ->native(false)
                            ->preload()
                            ->required()
                            ->columnSpan(4),
                        TextInput::make('code')
                            ->label('PR No.')
                            ->placeholder('Automatically generate after save')
                            ->readOnly()
                            ->columnSpan(3),
                        DatePicker::make('doc_date')
                            ->label('Date')
                            ->required()
                            ->default(now())
                            ->columnSpan(2),
                        Select::make('department_id')
                            ->label('Department')
                            // ->relationship('')
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
                                'critical' => 'Critical'
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
                    ->relationship()
                    ->table([
                        TableColumn::make('Material'),
                        TableColumn::make('Specification'),
                        TableColumn::make('UoM'),
                        TableColumn::make('Qty'),
                        TableColumn::make('Arrival Date'),
                        TableColumn::make('Suggest Supplier'),
                        TableColumn::make('Remark')
                    ])
                    ->compact()
                    ->schema([
                        Select::make('material_id')
                            ->label('Material')
                            // ->relationship('')
                            ->searchable()
                            ->required()
                            ->native(false)
                            ->preload(),
                        TextInput::make('specification')
                            ->label('Specification')
                            ->placeholder('Specification')
                            ->readonly(),
                        Select::make('unit_id')
                            ->label('UoM')
                            ->required()
                            // ->relationship()
                            ->searchable()
                            ->native(false)
                            ->preload(),
                        TextInput::make('qty')
                            ->label('Qty')
                            ->numeric()
                            ->mask(RawJs::make('$money($input)'))
                            ->default(1)
                            ->required(),
                        DatePicker::make('arrival_date')
                            ->label('Required Arrival Date')
                            ->required(),
                        Select::make('supplier_id')
                            ->label('Default Supplier')
                            // ->relationship()
                            ->searchable()
                            ->native(false)
                            ->preload(),
                        TextInput::make('remark')
                            ->label('Remark')
                            ->placeholder('Remark ...')
                    ])
                    ->columnSpanFull()
            ]);
    }
}
