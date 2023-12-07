<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
<<<<<<< HEAD
<<<<<<< HEAD
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
use Filament\Pages\Dashboard;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationItem;
use App\Filament\Pages\Auth\EditProfile;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Dasundev\FilamentAccessSecret\Middleware\VerifyAdminAccessSecret;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
<<<<<<< HEAD
<<<<<<< HEAD
            ->registration()
            ->colors([
                'primary' => Color::Amber,
            ])
=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
            ->passwordReset()
            ->emailVerification()
            ->profile(EditProfile::class)
            ->colors([
                'primary' => Color::rgb('rgb(16, 185, 129)'),
            ])
            ->sidebarCollapsibleOnDesktop()
            ->font('Poppins')
            ->favicon(asset('/storage/media/favicon/logo.png'))
            ->brandName(config('app.name'))
            //->brandLogo(asset('/storage/media/favicon/logo.png'))
            //->brandLogoHeight('2rem')
<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
            ->authMiddleware([
                Authenticate::class,
<<<<<<< HEAD
<<<<<<< HEAD
            ]);
    }

    #R0NsaWVudFNlY3JldD1HT0NTUFgtWmRtMVJWb1NmYThVdGxidTFBX1EzNFlSZGdVdg==
    #T0F1dGhDbGllbnRJRD01NzQ0NzA3NjM1My1kMzA2OXNiaDUzMmtkbmRib29vODQ2b2V2cW1ucTV1ZS5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbQ==
=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
            ])
            ->userMenuItems([
                'logout' => MenuItem::make()->label('Log out'),
            ]);
    }
<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
}
