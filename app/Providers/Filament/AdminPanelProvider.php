<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\CustomLogin;
use App\Models\Company;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Closure;
use Filament\Actions\CreateAction;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $logoUrl = null;
        $brandLogo = null;
        $brandName = 'Schlemmer Automotive Indonesia';

        try {
            if (Schema::hasTable('companies')) {
                $company = Company::first();

                if ($company) {
                    $brandName = $company->name ?? $brandName;

                    if ($company->logo) {
                        $brandLogo = Storage::url($company->logo);
                    }

                    if ($company->favicon) {
                        $logoUrl = Storage::url($company->favicon);
                    }
                }
            }
        } catch (\Exception $e) {
        }

        return $panel
            ->default()
            ->id('admin')
            ->path('')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login(CustomLogin::class)
            ->passwordReset()
            ->profile()
            ->spa()
            // ->viteTheme('resources/css/filament/admin/theme.css')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->brandName($brandName)
            ->favicon($logoUrl)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 1,
                        'sm' => 2,
                    ])
                    ->sectionColumns(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3,
                    ])
                    // Gunakan method ini untuk mematikan icon di navigasi
                    ->navigationIcon(null)
                    ->navigationSort(2)
                    ->navigationGroup('User Management'),

            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Transaction')
                    ->icon(null)
                    ->collapsed(),
                NavigationGroup::make()
                    ->label('Master Data')
                    ->icon(null)
                    ->collapsed(),
                NavigationGroup::make()
                    ->label('User Management')
                    ->icon(null)
                    ->collapsed(),
                NavigationGroup::make()
                    ->label('Application Setup')
                    ->icon(null)
                    ->collapsed(),
            ])
            ->globalSearch();
    }
}
