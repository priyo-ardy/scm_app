<?php

namespace App\Filament\Resources\PurchaseOrders\Schemas;

use App\Models\Supplier;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;
use Illuminate\Database\Eloquent\Builder;

class PurchaseOrderForm
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
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->columnSpan(4)
                            ->required(),
                        TextInput::make('code')
                            ->label('Code')
                            ->readOnly()
                            ->columnSpan(2)
                            ->placeholder('Automatic generate after save'),
                        DatePicker::make('doc_date')
                            ->label('Date')
                            ->required()
                            ->default(now())
                            ->columnSpan(2),
                        Select::make('department_id')
                            ->label('Requested Department')
                            ->relationship('department', 'name', modifyQueryUsing: fn(Builder $query) => $query->where('is_active', true)->orderBy('name', 'asc'))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('doc_status')
                            ->label('Document Status')
                            ->columnSpan(2)
                            ->default('draft')
                            ->readOnly(),
                        Select::make('supplier_id')
                            ->label('Supplier')
                            ->relationship('supplier', 'name', modifyQueryUsing: fn(Builder $query) => $query->where('is_active', true)->orderBy('name', 'asc'))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {
                                if (!$state) {
                                    $set('currency_id', null);
                                    $set('exchange_rate', 1);
                                    $set('payment_term_id', null);
                                }

                                $supplier = Supplier::find($state);

                                if ($supplier && $supplier->id) {
                                    $set('currency_id', $supplier->default_currency);
                                    $set('payment_term_id', $supplier->payment_term_id);
                                }
                            })
                            ->columnSpan(4),
                        Select::make('currency_id')
                            ->label('Currency')
                            ->relationship('currency', 'code', modifyQueryUsing: fn(Builder $query) => $query->where('is_active', true)->orderBy('code', 'asc'))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('exchange_rate')
                            ->label('Exchange Rate')
                            ->numeric()
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->live(onBlur: true)
                            ->columnSpan(2)
                            ->placeholder('Exchange Rate')
                            ->required()
                            ->default(1)
                            ->extraInputAttributes(['style' => 'text-align: right']),
                        Select::make('payment_term_id')
                            ->label('Payment Term')
                            ->relationship('paymentTerm', 'name', modifyQueryUsing: fn(Builder $query) => $query->where('is_active', true)->orderBy('name', 'asc'))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->columnSpan(3),
                        TextInput::make('printed_count')
                            ->label('Print Count')
                            ->default(0)
                            ->columnSpan(1)
                            ->readOnly()
                            ->numeric()
                            ->extraInputAttributes(['style' => 'text-align: right']),
                        Select::make('purchase_requisition_id')
                            ->label('Purchase Requisition')
                            ->relationship('purchaseRequisition', 'code', modifyQueryUsing: fn(Builder $query) => $query->where('doc_status', 'approved')->orderBy('code', 'desc'))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->columnSpan(3)
                            ->required(),
                        Textarea::make('shipping_address')
                            ->label('Shipping Address')
                            ->columnSpan(9)
                            ->rows(3)
                    ])
                    ->columns(12)
                    ->columnSpanFull()
            ]);
    }
}
