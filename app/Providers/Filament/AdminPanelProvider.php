<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Actions\Action;
use Firefly\FilamentBlog\Blog;
use Filament\Support\Colors\Color;
use Guava\Tutorials\TutorialsPlugin;
use App\Filament\Admin\Themes\Awesome;
use Orion\FilamentGreeter\GreeterPlugin;
use Filament\Http\Middleware\Authenticate;
use Rmsramos\Activitylog\ActivitylogPlugin;
use Awcodes\FilamentVersions\VersionsPlugin;
use Awcodes\FilamentVersions\VersionsWidget;
use Filament\SpatieLaravelTranslatablePlugin;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use TomatoPHP\FilamentUsers\FilamentUsersPlugin;
use TomatoPHP\FilamentLogger\FilamentLoggerPlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Rupadana\FilamentAnnounce\FilamentAnnouncePlugin;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use TomatoPHP\FilamentAccounts\FilamentAccountsPlugin;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Awcodes\FilamentVersions\Providers\Contracts\VersionProvider;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Joaopaulolndev\FilamentGeneralSettings\FilamentGeneralSettingsPlugin;
use Statikbe\FilamentTranslationManager\FilamentChainedTranslationManagerPlugin;


class MyCustomVersionProvider implements VersionProvider
{
    public function getName(): string
    {
        return 'My Custom Version';
    }

    public function getVersion(): string
    {
        return '1.0.0';
    }
}

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Purple,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
                VersionsWidget::class,
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
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->tenantMiddleware([
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class
            ])
            ->plugins([
                FilamentEditProfilePlugin::make(),
                Blog::make(),
                FilamentAnnouncePlugin::make()
                    ->pollingInterval('30s') // optional, by default it is set to null
                    ->defaultColor(Color::Blue), // optional, by default it is set to "primary"
                // Impersonate::make(),
                // Impersonate::make('impersonate')
                //     ->guard('another-guard')
                //     ->redirectTo(route('some.other.route')),
                ActivitylogPlugin::make(),
                FilamentGeneralSettingsPlugin::make(),
                FilamentUsersPlugin::make(),
                FilamentShieldPlugin::make(),
                FilamentLoggerPlugin::make(),
                FilamentAccountsPlugin::make(),
                VersionsPlugin::make()
                    ->widgetColumnSpan('full')
                    ->widgetSort(2)
                    ->items([
                        new MyCustomVersionProvider(),
                    ]),
                FilamentChainedTranslationManagerPlugin::make(),
                GreeterPlugin::make()
                    ->message('Welcome,')
                    ->name('Daenerys Targaryen')
                    ->title('The First of Her Name, the Unburnt, Queen of Meereen, Queen of the Andals and the Rhoynar and the First Men, Khalisee of the Great Grass Sea, Breaker of Chains and Mother of Dragons')
                    ->avatar(size: 'w-16 h-16', url: 'https://avatarfiles.alphacoders.com/236/236674.jpg')
                    ->action(
                        Action::make('action')
                            ->label('Buy more unsullied')
                            ->icon('heroicon-o-shopping-cart')
                            ->url('https://buyunsulliedonline.com')
                    )
                    ->sort(-1)
                    ->columnSpan('full'),
                TutorialsPlugin::make(),
                SpatieLaravelTranslatablePlugin::make()
                    ->defaultLocales(['fr', 'en']),
                \Hasnayeen\Themes\ThemesPlugin::make(),
                    // ->registerTheme([Awesome::getName() => Awesome::class])
            ]);
    }
}

