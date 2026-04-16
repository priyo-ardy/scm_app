<?php

namespace App\Filament\Resources\PaymentTerms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PaymentTermForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('code')
                            ->label('Code')
                            ->readOnly()
                            ->placeholder('Automatic generated after save')
                            ->columnSpan(2),
                        Select::make('bill_period_basis')
                            ->label('Bill Period Basis')
                            ->options([
                                'business_date' => 'Business date',
                                'order_date' => 'Order date',
                                'material_receipt' => 'Material receipt',
                                'warehouse_receipt' => 'Warehouse receipt',
                            ])
                            ->searchable()
                            ->required()
                            ->columnSpan(3),
                        TextInput::make('name')
                            ->label('Name')
                            ->placeholder('Payment terms name')
                            ->autocomplete(false)
                            ->maxLength(150)
                            ->required()
                            ->columnSpan(7),
                        Textarea::make('description')
                            ->default(null)
                            ->placeholder('Additional information')
                            ->columnSpanFull(),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
            ]);
    }
}
