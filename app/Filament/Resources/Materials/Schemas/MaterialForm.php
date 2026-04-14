<?php

namespace App\Filament\Resources\Materials\Schemas;

use App\Models\MaterialCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class MaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->description('Basic Information')
                    ->schema([
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('companyList', 'name')
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan(3),
                        Select::make('category_id')
                            ->label('Category')
                            ->relationship('categoryList', 'name', fn($query) => $query->where('is_active', '1')->orderBy('code', 'asc'))
                            ->getOptionLabelFromRecordUsing(function ($record) {
                                $depth = substr_count($record->code, '.');
                                $indent = str_repeat('   ', $depth);

                                return "{$indent}{$record->code} - {$record->name}";
                            })
                            ->required()
                            ->searchable(['code', 'name'])
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (string $state, Set $set) {
                                if (!$state) {
                                    $set('code', '');
                                    return;
                                }

                                $category = MaterialCategory::find($state);

                                if ($category) {
                                    $set('code', $category->code . '.');
                                }
                            })
                            ->columnSpan(4),
                        TextInput::make('code')
                            ->label('Material Code')
                            ->required()
                            ->maxLength(150)
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'This code already registered'
                            ])
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                $categoryId = $get('category_id');
                                if (! $categoryId) return;

                                $categoryCode = MaterialCategory::find($categoryId)?->code . '.';

                                // Jika user mencoba menghapus atau merubah awalan kategori
                                if (! str_starts_with($state, $categoryCode)) {
                                    // Paksa balikin ke kode kategori semula
                                    $set('code', $categoryCode);
                                }
                            })
                            ->autocomplete(false)
                            ->columnSpan(5),
                        TextInput::make('name')
                            ->label('Material Name')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('Material Name')
                            ->autocomplete(false)
                            ->columnSpan(5),
                        Textarea::make('specification')
                            ->label('Specification')
                            ->required()
                            ->placeholder('Material specification')
                            ->autocomplete(false)
                            ->columnSpan(7),
                        Select::make('properties')
                            ->label('Material Properties')
                            ->required()
                            ->searchable()
                            ->options([
                                'purchase'      => '1. Purchase',
                                'self_made'     => '2. Self made',
                                'sub_contract'  => '3. Sub contract',
                                'configure'     => '4. Configure',
                                'asset'         => '5. Asset',
                                'feature'       => '6. Feature',
                                'expense'       => '7. Expense',
                                'virtual'       => '8. Virtual',
                                'service'       => '9. Service',
                            ])
                            ->default('purchase')
                            ->columnSpan(2),
                        Select::make('workshop_id')
                            ->label('Workshop')
                            ->relationship('workshopList', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(3),
                        Select::make('supplier_id')
                            ->label('Default Supplier')
                            ->searchable()
                            ->preload()
                            ->relationship('supplierList', 'name')
                            ->columnSpan(4),
                        TextInput::make('hs_code')
                            ->label('HS Code')
                            ->default(null)
                            ->placeholder('HS Code')
                            ->columnSpan(3),
                        Select::make('regrind_method')
                            ->label('Regrind Method')
                            ->searchable()
                            ->options(['inline' => 'Inline', 'offline' => 'Offline', 'no_regrind' => 'No regrind'])
                            ->columnSpan(2),
                        Select::make('status')
                            ->label('Material Status')
                            ->searchable()
                            ->options(['draft' => 'Draft', 'active' => 'Active', 'phase_out' => 'Phase out', 'obsolete' => 'Obsolete'])
                            ->required()
                            ->default('draft')
                            ->searchable()
                            ->columnSpan(2),
                        TextInput::make('last_purchase_price')
                            ->readOnly()
                            ->numeric()
                            ->default(0.0)
                            ->prefix('Rp')
                            ->columnSpan(2),
                        Select::make('is_hazardous')
                            ->label('Is Hazardous')
                            ->options([
                                '0' => 'No',
                                '1' => 'Yes'
                            ])
                            ->default(0)
                            ->searchable()
                            ->columnSpan(2),
                        Select::make('tonnage_id')
                            ->label('Tonnage')
                            ->relationship('tonnageList', 'code')
                            ->searchable(['code'])
                            ->preload()
                            ->columnSpan(2),
                        TextInput::make('cust_part_no')
                            ->label('Customer Part No.')
                            ->placeholder('Customer Part No')
                            ->maxLength(150)
                            ->default(null)
                            ->columnSpan(3),
                        TextInput::make('cust_part_name')
                            ->label('Customer Part Name')
                            ->placeholder('Customer Part Name')
                            ->default(null)
                            ->maxLength(150)
                            ->columnSpan(4),
                        TextInput::make('delivery_location')
                            ->label('Delivery Location')
                            ->placeholder('Initial of customer affiliates like SAMI, SAI, JAI, ect')
                            ->maxLength(150)
                            ->default(null)
                            ->columnSpan(5),
                        Textarea::make('description')
                            ->default(null)
                            ->columnSpanFull(),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
                Section::make()
                    ->description('Material Properties')
                    ->schema([
                        Select::make('unit_id')
                            ->label('Unit')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship('unitList', 'code')
                            ->columnSpan(2),
                        Select::make('purchase_unit_id')
                            ->label('Purchase Unit')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship('purchaseUnitList', 'code')
                            ->columnSpan(2),
                        TextInput::make('unit_conversion_rate')
                            ->label('Unit Coversion Rate')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->columnSpan(2),
                        TextInput::make('spq')
                            ->label('SPQ')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->columnSpan(2),
                        TextInput::make('qty_bag')
                            ->label('Qty/Bag')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->columnSpan(2),
                        TextInput::make('net_weight')
                            ->label('Net Weight')
                            ->numeric()
                            ->step('0.0001')
                            ->placeholder('Net Weight')
                            ->columnSpan(2)
                            ->extraInputAttributes([
                                'style' => '-moz-appearance: textfield;', // Untuk Firefox
                            ])
                            ->extraAttributes([
                                'class' => '[&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none', // Untuk Chrome/Safari/Edge
                            ])
                            ->default(0),
                        TextInput::make('gross_weight')
                            ->label('Gross Weight')
                            ->numeric()
                            ->step('0.00001')
                            ->placeholder('Gross Weight')
                            ->default(0)
                            ->columnSpan(2),
                        TextInput::make('sprue')
                            ->label('Sprue Weight')
                            ->numeric()
                            ->step('0.00001')
                            ->readOnly()
                            ->default(0)
                            ->columnSpan(2)
                            ->placeholder('Sprue Weight'),
                        TextInput::make('cycle_time')
                            ->label('Cycle Time')
                            ->numeric()
                            ->step('0.00')
                            ->placeholder('Cycle Time')
                            ->default(0)
                            ->columnSpan(2),
                        TextInput::make('shift_capacity')
                            ->label('Shift Capacity')
                            ->numeric()
                            ->step(1)
                            ->default(0)
                            ->columnSpan(2),
                        TextInput::make('color')
                            ->label('Material Color')
                            ->maxLength(20)
                            ->columnSpan(2),
                        TextInput::make('cavity')
                            ->label('Number of Cavity')
                            ->numeric()
                            ->step(1)
                            ->default(0)
                            ->placeholder('Number of Cavity')
                            ->columnSpan(2),
                        TextInput::make('drawing_no')
                            ->label('Drawing No.')
                            ->maxLength(150)
                            ->placeholder('Drawing No.')
                            ->default(null)
                            ->columnSpan(2),
                        TextInput::make('revision_no')
                            ->label('Revision No.')
                            ->default(null)
                            ->maxLength(20)
                            ->placeholder('Revision No.')
                            ->columnSpan(2),
                        TextInput::make('drawing_level')
                            ->label('Drawing Level')
                            ->default(null)
                            ->maxLength(20)
                            ->placeholder('Drawing Level')
                            ->columnSpan(2),
                        TextInput::make('process_routes')
                            ->label('Process Route')
                            ->maxLength(150)
                            ->placeholder('Process Routes')
                            ->default(null)
                            ->columnSpan(6)
                    ])
                    ->columns(12)
                    ->columnSpanFull()
                    ->collapsed(false),
                Section::make()
                    ->description('Inventory Config')
                    ->schema([
                        Select::make('enable_min_stock')
                            ->label('Enable Min Stock')
                            ->options([
                                '0' => 'No',
                                '1' => 'Yes'
                            ])
                            ->columnSpan(2)
                            ->default(0),
                        TextInput::make('min_stock')
                            ->required()
                            ->numeric()
                            ->default(0.0)
                            ->columnSpan(2),
                        Select::make('enable_safety_stock')
                            ->label('Enable Safety Stock')
                            ->options([
                                '0' => 'No',
                                '1' => 'Yes'
                            ])
                            ->columnSpan(2)
                            ->default(0),
                        TextInput::make('safety_stock')
                            ->required()
                            ->numeric()
                            ->default(0.0)
                            ->columnSpan(2),
                        Select::make('enable_max_stock')
                            ->label('Enable Max Stock')
                            ->options([
                                '0' => 'No',
                                '1' => 'Yes'
                            ])
                            ->columnSpan(2)
                            ->default(0),
                        TextInput::make('max_stock')
                            ->required()
                            ->numeric()
                            ->default(0.0)
                            ->columnSpan(2),
                        TextInput::make('reorder_point')
                            ->required()
                            ->numeric()
                            ->default(0.0)
                            ->columnSpan(2),
                        TextInput::make('storage_location_id')
                            ->label('Storage Location')
                            ->columnSpan(2),
                        Select::make('enable_expired')
                            ->label('Enable Expired')
                            ->options([
                                '0' => 'No',
                                '1' => 'Yes'
                            ])
                            ->columnSpan(2),
                        TextInput::make('expiry_days')
                            ->label('Expired Days')
                            ->numeric()
                            ->default(0)
                            ->columnSpan(2),
                        TextInput::make('lead_time_days')
                            ->label('Lead Time Days')
                            ->numeric()
                            ->default(0)
                            ->columnSpan(2),
                        Select::make('is_inspection_required')
                            ->label('Required Inspection')
                            ->required()
                            ->options([
                                '0' => 'No',
                                '1' => 'Yes'
                            ])
                            ->default('0')
                            ->columnSpan(2)
                    ])
                    ->columns(12)
                    ->columnSpanFull()
                    ->collapsed(false),
                Section::make()
                    ->description('Packaging Information')
                    ->schema([
                        Select::make('dimension_unit_id')
                            ->label('Dimension Unit')
                            ->searchable()
                            ->preload()
                            ->relationship('dimensionUnitList', 'code')
                            ->columnSpan(2),
                        Select::make('carton_category')
                            ->label('Carton Category')
                            ->searchable()
                            ->options([
                                'A' => 'A',
                                'B' => 'B',
                                'C' => 'C',
                                'D' => 'D',
                                'E' => 'E',
                            ])
                            ->columnSpan(2),
                        TextInput::make('carton_length')
                            ->label('Carton Length')
                            ->numeric()
                            ->default(0.0)
                            ->columnSpan(2),
                        TextInput::make('carton_width')
                            ->label('Carton Width')
                            ->numeric()
                            ->default(0.0)
                            ->columnSpan(2),
                        TextInput::make('carton_height')
                            ->label('Carton Height')
                            ->numeric()
                            ->default(0.0)
                            ->columnSpan(2),
                        TextInput::make('stacking_limit')
                            ->label('Stacking Limit')
                            ->numeric()
                            ->default(0)
                            ->columnSpan(2),
                    ])
                    ->columns(12)
                    ->columnSpanFull()
                    ->collapsed(false),
                Section::make()
                    ->description('Material Image')
                    ->schema([
                        FileUpload::make('avatar')
                            ->hiddenLabel()
                            ->image()
                            ->imageEditor()
                            ->alignCenter()
                            ->visibility('public')
                            ->directory('material-avatar')
                            ->disk('public')
                            ->saveRelationshipsUsing(null)
                            ->maxSize(10240)
                            ->openable()
                            ->imageAspectRatio(['16:9', '4:3', '1:1'])
                            ->loadingIndicatorPosition('bottom')
                            ->panelLayout('grid')
                            ->imageEditorMode(2)
                            ->multiple()
                            ->maxFiles(5)
                            ->reorderable()
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, Get $get): string {
                                $materialCode = $get('code');
                                if (filled($materialCode)) {
                                    $safeCode = str_replace(['/', '\\', '?', '*', ':', '|', '"', '<', '>', ' '], '-', $materialCode);
                                    return (string) str($safeCode . '-' . now()->timestamp . '-' . uniqid() . '.' . $file->getClientOriginalExtension());
                                }
                                return $file->hashName();
                            })
                            ->rules([
                                function () {
                                    return function (string $attribute, $value, \Closure $fail) {
                                        // $value di sini isinya adalah array file-file yang diupload
                                        if (is_array($value)) {
                                            $totalSize = 0;
                                            foreach ($value as $file) {
                                                // Jika file baru (TemporaryUploadedFile)
                                                if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                                                    $totalSize += $file->getSize();
                                                }
                                                // Jika file lama (sudah ada di server/string path)
                                                // Kita bisa abaikan atau hitung sesuai kebutuhan
                                            }

                                            $maxTotal = 50 * 1024 * 1024; // 50MB dalam Bytes
                                            if ($totalSize > $maxTotal) {
                                                $fail("The total size of all images must not exceed 50MB.");
                                            }
                                        }
                                    };
                                },
                            ])
                            ->columnSpanFull()
                    ])->columnSpanFull()
                    ->collapsed(false)
            ]);
    }
}
