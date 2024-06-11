<?php

namespace App\Providers\Filament;

use App\Billing\SubscriptionBillingProvider;
use App\Models\Tenant;
use App\Filament\Pages\Tenancy\RegisterTenant;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $subdomainUrlConfig = '{tenant:slug}.' . env('TENANT_URL_DOMAIN');
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->tenant(Tenant::class, slugAttribute: 'slug')
            ->tenantRegistration(RegisterTenant::class)
            ->tenantDomain($subdomainUrlConfig)
            ->colors([
                'primary' => '#4B8130',
            ])
            ->brandName('MK Place')
            ->brandLogo(asset('images/logo-custom.png'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                //Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([])
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
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
            ])
            ->requiresTenantSubscription()
            ->tenantBillingProvider(new SubscriptionBillingProvider())
            ->spa();
    }
}
