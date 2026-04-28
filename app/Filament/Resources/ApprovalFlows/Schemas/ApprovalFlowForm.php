<?php

namespace App\Filament\Resources\ApprovalFlows\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ApprovalFlowForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('code')
                            ->label('Document Code')
                            ->maxLength(20)
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'This document code already registered'
                            ])
                            ->placeholder('Document Code')
                            ->autofocus()
                            ->autocomplete(false)
                            ->required()
                            ->columnSpan(4),
                        TextInput::make('name')
                            ->label('Document Name')
                            ->maxLength(150)
                            ->placeholder('Document Name')
                            ->autocomplete(false)
                            ->required()
                            ->columnSpan(8),
                    ])->columns(12)
                    ->columnSpanFull(),
                Section::make()
                    ->schema([
                        Repeater::make('steps')
                            ->relationship('steps')
                            ->schema([
                                TextInput::make('order')
                                    ->label('Approver Order')
                                    ->numeric()
                                    ->required()
                                    ->placeholder('Approver Order')
                                    ->columnSpan(2),
                                Select::make('role_name')
                                    ->label('Select Approver Role')
                                    ->required()
                                    ->searchable()
                                    ->options([
                                        'Section Head' => 'Section Head',
                                        'Dept Manager' => 'Dept Manager',
                                        'Vice GM' => 'Vice GM',
                                        'Finance' => 'Finance',
                                    ])->columnSpan(4),
                                Select::make('approver_id')
                                    ->label('Select Approver')
                                    ->required()
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->native()
                                    ->columnSpan(6),
                            ])
                            ->columns(12)
                            ->itemNumbers()
                            ->cloneable()
                            ->reorderable()
                            ->collapsible()
                            ->orderColumn('order')
                            ->reorderableWithButtons()
                            ->reorderableWithDragAndDrop(),
                    ])
                    ->columns(1)
                    ->columnSpanFull(),
            ]);
    }
}
