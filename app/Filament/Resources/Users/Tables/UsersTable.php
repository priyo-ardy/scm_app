<?php

namespace App\Filament\Resources\Users\Tables;

use App\Filament\Exports\UsersExporter;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\QueryBuilder\Constraints\DateConstraint;
use Filament\QueryBuilder\Constraints\SelectConstraint;
use Filament\QueryBuilder\Constraints\TextConstraint;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->circular()
                    ->disk('public')
                    ->visibility('public')
                    ->toggleable(),
                TextColumn::make('companyList.slug')
                    ->label('Assign to Company')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->label('Full Name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('email')
                    ->label('Email Address')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('phone')
                    ->label('Phone Number')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('roles.name')
                    ->label('User Role')
                    ->formatStateUsing(fn(string $state): string => ucfirst($state))
                    ->formatStateUsing(fn(string $state): string => Str::headline($state))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'super_admin' => 'danger',
                        'admin' => 'warning',
                        'manager' => 'success',
                        'supervisor' => 'info',
                        'leader' => 'primary',
                        'staff' => 'secondary',
                        'guest' => 'gray',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('is_locked')
                    ->label('Locked Status')
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Locked' : 'Unlocked')
                    ->badge()
                    ->color(fn(bool $state): string => $state ? 'danger' : 'success')
                    ->alignCenter()
                    ->toggleable(),
                TextColumn::make('department.name')
                    ->label('Department')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('last_login')
                    ->dateTime('D, jS M Y, h:i:s')
                    ->sortable()
                    ->searchable()
                    ->label('Last Login')
                    ->toggleable(),
                TextColumn::make('last_login_from')
                    ->label('Last Login From')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('is_active')
                    ->badge()
                    ->label('Status')
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Active' : 'Not Active')
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                    ->alignCenter()
                    ->toggleable(),
                TextColumn::make('remark')
                    ->label('Remark')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        // Text
                        TextConstraint::make('name')->label('Full Name'),
                        TextConstraint::make('email')->label('Email Address'),
                        TextConstraint::make('phone')->label('Phone No.'),

                        // Select
                        SelectConstraint::make('is_locked')
                            ->options([
                                '0' => 'No',
                                '1' => 'Yes',
                            ])->searchable(),

                        // Date
                        DateConstraint::make('last_login')
                            ->label('Last Login'),
                    ])
                    ->constraintPickerColumns(1),
            ], layout: FiltersLayout::Modal)
            ->filtersFormColumns(1)
            ->filtersFormWidth('4xl')
            ->persistFiltersInSession()
            ->filtersTriggerAction(
                fn($action) => $action
                    ->button()
                    ->label('Filter')
                    ->icon('heroicon-o-funnel')
            )
            ->recordActions([
                // ViewAction::make(),
                // EditAction::make(),
                // DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    BulkAction::make('bulkEdit')
                        ->label('Mass Edit')
                        ->color('warning')
                        ->icon(Heroicon::OutlinedPencilSquare)
                        ->schema([
                            Select::make('column_to_update')
                                ->label('Edit field name')
                                ->searchable()
                                ->live()
                                ->options([
                                    'login_attempt' => 'Login Attempts',
                                    'is_locked' => 'Locking Status',
                                    'role' => 'User Role',
                                    'is_active' => 'Status',
                                ]),
                            TextInput::make('value_login_attempt')
                                ->label('Login attempts')
                                ->visible(fn(Get $get) => $get('column_to_update') === 'login_attempt')
                                ->numeric()
                                ->placeholder('Change login failure attempt'),
                            Select::make('value_is_locked')
                                ->label('Select locking status')
                                ->options([
                                    '0' => 'No',
                                    '1' => 'Locked',
                                ])->searchable()
                                ->visible(fn(Get $get) => $get('column_to_update') === 'is_locked'),
                            Select::make('value_role')
                                ->label('Select user role')
                                ->relationship('roles', 'name')
                                ->searchable()
                                ->preload()
                                ->visible(fn(Get $get) => $get('column_to_update') === 'role'),
                            Select::make('value_is_active')
                                ->label('Select status')
                                ->options([
                                    '0' => 'No',
                                    '1' => 'Active',
                                ])->searchable()
                                ->visible(fn(Get $get) => $get('column_to_update') === 'is_active'),
                            TextInput::make('value_string')
                                ->label('New Text Value')
                                ->visible(fn(Get $get) => in_array($get('column_to_update'), ['login_attempt']))
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $column = $data['column_to_update'];

                            // Tentukan value baru berdasarkan input yang visible
                            $newValue = match ($column) {
                                'login_attempt' => $data['value_login_attempt'],
                                'is_locked' => $data['value_is_locked'],
                                'is_active' => $data['value_is_active'],
                                'role' => $data['value_role'],
                                default => null,
                            };

                            $records->each(function ($record) use ($column, $newValue) {
                                if ($column === 'role') {
                                    // Khusus Role, pake sync() karena Many-to-Many
                                    // Pastikan model User punya method roles()
                                    $record->roles()->sync([$newValue]);
                                } else {
                                    // Untuk kolom biasa
                                    $record->update([
                                        $column => $newValue,
                                    ]);
                                }
                            });

                            Notification::make()
                                ->title('Mass edit success')
                                ->body(count($records) . ' records updated.')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
                Action::make('refresh')
                    ->label('Refresh')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->action(fn() => null),
                ExportAction::make('export')
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->exporter(UsersExporter::class),
            ]);
    }
}
