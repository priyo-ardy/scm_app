<?php

namespace App\Filament\Resources\Users\Tables;

use App\Filament\Exports\UsersExporter;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\QueryBuilder\Constraints\DateConstraint;
use Filament\QueryBuilder\Constraints\SelectConstraint;
use Filament\QueryBuilder\Constraints\TextConstraint;
use Filament\Schemas\Components\Grid;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
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
                    ->visibility('public'),
                TextColumn::make('name')
                    ->label('Full Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email Address')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Phone Number')
                    ->searchable()
                    ->sortable(),
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
                    ->sortable(),
                TextColumn::make('is_locked')
                    ->label('Locked Status')
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Locked' : 'Unlocked')
                    ->badge()
                    ->color(fn(bool $state): string => $state ? 'danger' : 'success')
                    ->alignCenter(),
                TextColumn::make('last_login')
                    ->dateTime('D, jS M Y, h:i:s')
                    ->sortable()
                    ->searchable()
                    ->label('Last Login'),
                TextColumn::make('last_login_from')
                    ->label('Last Login From')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('remark')
                    ->label('Remark')
                    ->searchable()
                    ->sortable(),

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
                                '1' => 'Yes'
                            ])->searchable(),

                        // Date
                        DateConstraint::make('last_login')
                            ->label('Last Login')
                    ])
                    ->constraintPickerColumns(1)
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
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
                Action::make('refresh')
                    ->label('Refresh')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->action(fn() => null),
                ExportAction::make('export')
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->exporter(UsersExporter::class)
            ]);
    }
}
