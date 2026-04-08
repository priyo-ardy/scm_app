<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\View;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
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
                Filter::make('user_filter')
                    ->columns(3)
                    ->schema([
                        TextInput::make('name')->label('Full Name')->placeholder('Search with full name ...')->autocomplete(false),
                        TextInput::make('email')->label('User Email')->placeholder('Search with email address ...')->autocomplete(false),
                        TextInput::make('phone')->label('User Phone')->placeholder('Search with phone number ...')->autocomplete(false),
                        Select::make('role')
                            ->label('User Role')
                            ->relationship('roles', 'name')
                            ->native()
                            ->searchable()
                            ->preload()
                            ->multiple(),
                        Select::make('is_locked')
                            ->label('Locked Status')
                            ->options([
                                'true' => 'Locked',
                                'false' => 'Unlocked',
                            ])
                            ->native()
                            ->searchable(),
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('created_from')
                                    ->label('Created From')
                                    ->placeholder('Dari Tanggal'),

                                DatePicker::make('created_until')
                                    ->label('Created Until')
                                    ->placeholder('Sampai Tanggal'),
                            ])->columnSpan(3)
                    ])->columns(3)
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['name'],
                                fn(Builder $query, $name): Builder => $query->where('name', 'like', "%{$name}%"),
                            )
                            ->when(
                                $data['email'],
                                fn(Builder $query, $email): Builder => $query->where('email', 'like', "%{$email}%"),
                            )
                            ->when(
                                $data['phone'],
                                fn(Builder $query, $phone): Builder => $query->where('phone', 'like', "%{$phone}%"),
                            )
                            ->when(
                                $data['is_locked'],
                                fn(Builder $query, $is_locked): Builder => $query->where('is_locked', $is_locked),
                            )
                            ->when(
                                $data['role'],
                                fn(Builder $query, $role): Builder => $query->where('role', $role),
                            )
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['name'] ?? null) {
                            $indicators[] = 'Name: ' . $data['name'];
                        }
                        if ($data['email'] ?? null) {
                            $indicators[] = 'Email: ' . $data['email'];
                        }
                        if ($data['phone'] ?? null) {
                            $indicators[] = 'Phone: ' . $data['phone'];
                        }
                        return $indicators;
                    })
            ])
            ->filtersLayout(FiltersLayout::Modal)
            // ->filtersFormColumns(3)
            ->filtersFormWidth('4xl')
            ->filtersTriggerAction(
                fn($action) => $action
                    ->button()
                    ->label('Filter')
                    ->icon('heroicon-o-funnel')
            )
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
