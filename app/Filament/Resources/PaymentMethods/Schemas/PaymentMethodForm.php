<?php

namespace App\Filament\Resources\PaymentMethods\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PaymentMethodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('code')
                            ->label('Code')
                            ->readOnly()
                            ->placeholder('Automatic generate after save')
                            ->columnSpan(2),
                        TextInput::make('name')
                            ->label('Name')
                            ->maxLength(150)
                            ->columnSpan(4)
                            ->required()
                            ->placeholder('Payment method name')
                            ->autocomplete(false),
                        Select::make('category_id')
                            ->label('Settlement Category')
                            ->relationship('categoryList', 'name')
                            ->searchable()
                            ->preload()
                            ->columnSpan(3)
                            ->required(),
                        Select::make('type')
                            ->label('Business Type')
                            ->options([
                                'cash' => 'Cash',
                                'banking' => 'Banking',
                                'bill_transaction' => 'Bill Transaction',
                                'internal_settlement' => 'Internal Settlement'
                            ])
                            ->searchable()
                            ->default(null)
                            ->columnSpan(3),
                        Select::make('commission_fee')
                            ->label('Commission Fee')
                            ->options([
                                '0' => 'No',
                                '1' => 'Yes'
                            ])
                            ->searchable()
                            ->required()
                            ->columnSpan(2),
                        Select::make('payment_mode')
                            ->label('Payment Mode')
                            ->options([
                                'directly_withheld' => 'Directly Withheld'
                            ])
                            ->searchable()
                            ->default(null)
                            ->columnSpan(3),
                        Textarea::make('description')
                            ->required()
                            ->columnSpanFull()
                            ->nullable(),
                    ])
                    ->columns(12)
                    ->columnSpanFull()
            ]);
    }
}
