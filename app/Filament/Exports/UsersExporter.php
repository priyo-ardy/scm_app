<?php

namespace App\Filament\Exports;

use App\Models\User;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class UsersExporter extends Exporter
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('companyList.name')->label('Company'),
            ExportColumn::make('name')->label('Full Name'),
            ExportColumn::make('email')->label('Email Address'),
            ExportColumn::make('phone')->label('Phone Number'),
            ExportColumn::make('roles.name')->label('Role')->formatStateUsing(fn($state) => ucwords(strtolower(str_replace('_', ' ', $state)))),
            ExportColumn::make('is_locked')
                ->label('Locked Status')
                ->formatStateUsing(fn(bool $state): string => $state ? 'Locked' : 'Unlocked'),
            ExportColumn::make('department.name')->label('Department'),
            ExportColumn::make('sectionList.name')->label('Section'),
            ExportColumn::make('last_login')->label('Last Login'),
            ExportColumn::make('last_login_from')->label('Last Login From'),
            ExportColumn::make('is_active')->label('Status')->formatStateUsing(fn($state) => $state ? 'Enable' : 'Disable'),
            ExportColumn::make('remark')->label('Remark'),
            ExportColumn::make('created_at')->label('Created At'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your users export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return 'list_of_users_' . now()->format('YmdHis');
    }
}
