<?php

namespace App\Filament\Resources\ApprovalFlows\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class ApprovalFlowForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('code')
                            ->label('Document Type')
                            ->options([
                                'purchase_price' => 'Purchase Price',
                                'purchase_requisition' => 'Purchase Requisition',
                            ])
                            ->searchable()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'This approval flow document already registered'
                            ])
                            ->columnSpan(3),
                        TextInput::make('name')
                            ->label('Approval Flow Name')
                            ->maxLength(150)
                            ->required()
                            ->autocomplete(false)
                            ->columnSpan(4)
                            ->placeholder('Approval flow name')
                            ->dehydrateStateUsing(fn($state) => is_string($state) ? trim($state) : $state),
                        Textarea::make('remark')
                            ->label('Description')
                            ->placeholder('Add additional information here ...')
                            ->default(null)
                            ->columnSpan(5)
                            ->dehydrateStateUsing(fn($state) => is_string($state) ? trim($state) : $state),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
                Section::make()
                    ->schema([
                        Repeater::make('steps')
                            ->label('Approval Flow Steps')
                            ->relationship()
                            ->table([
                                TableColumn::make('Approver Role'),
                                TableColumn::make('Approver'),
                            ])
                            ->schema([
                                Select::make('approver_role')
                                    ->label('Approver Roles')
                                    ->options([
                                        'direct_user' => 'Direct User',
                                        'section_head' => 'Section Head',
                                        'manager_dept' => 'Department Manager',
                                        'finance' => 'Finance Manager',
                                        'vice_gm' => 'Vice GM',
                                        'gm' => 'GM'
                                    ])
                                    ->searchable()
                                    ->required()
                                    ->preload()
                                    ->live()
                                    ->native(false),
                                Select::make('approver_id ')
                                    ->label('Approver')
                                    ->relationship('approver', 'name')
                                    ->searchable()
                                    ->required(fn(Get $get) => $get('approver_role') === 'direct_user')
                                    ->preload()
                                    ->native(false)
                            ])
                            ->orderColumn('order')
                            ->collapsible()
                            ->addActionLabel('Add Approver')
                            ->columns(2)
                            ->columnSpanFull()
                    ])
                    ->columns(12)
                    ->columnSpanFull()
            ]);
    }
}
