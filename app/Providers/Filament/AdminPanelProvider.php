<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Actions\Action;
use LaraZeus\Wind\WindPlugin;
use Firefly\FilamentBlog\Blog;
use Kenepa\Banner\BannerPlugin;
use Filament\Support\Colors\Color;
use Filafly\PhosphorIconReplacement;
use Guava\Tutorials\TutorialsPlugin;
use App\Filament\Admin\Themes\Awesome;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\Facades\Schedule;
use Orion\FilamentGreeter\GreeterPlugin;
use Stephenjude\FilamentBlog\BlogPlugin;
use RickDBCN\FilamentEmail\FilamentEmail;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
use Rmsramos\Activitylog\ActivitylogPlugin;
use Awcodes\FilamentVersions\VersionsPlugin;
use Awcodes\FilamentVersions\VersionsWidget;
use Filament\SpatieLaravelTranslatablePlugin;
use pxlrbt\FilamentSpotlight\SpotlightPlugin;
use Saasykit\FilamentOops\FilamentOopsPlugin;
use Illuminate\Session\Middleware\StartSession;
use Tapp\FilamentMailLog\FilamentMailLogPlugin;
use Illuminate\Cookie\Middleware\EncryptCookies;
use TomatoPHP\FilamentUsers\FilamentUsersPlugin;
use TomatoPHP\FilamentLogger\FilamentLoggerPlugin;
use Vormkracht10\FilamentMails\FilamentMailsPlugin;
use Awcodes\FilamentStickyHeader\StickyHeaderPlugin;
use Monzer\FilamentChatifyIntegration\ChatifyPlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use FilipFonal\FilamentLogManager\FilamentLogManager;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Mvenghaus\FilamentScheduleMonitor\FilamentPlugin;
use Rupadana\FilamentAnnounce\FilamentAnnouncePlugin;
use Vormkracht10\FilamentMails\Facades\FilamentMails;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use TomatoPHP\FilamentAccounts\FilamentAccountsPlugin;
use Visualbuilder\EmailTemplates\EmailTemplatesPlugin;
use A21ns1g4ts\FilamentShortUrl\FilamentShortUrlPlugin;
use Filament\Http\Middleware\DisableBladeIconComponents;
use CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin;
use Cmsmaxinc\FilamentErrorPages\FilamentErrorPagesPlugin;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Awcodes\FilamentVersions\Providers\Contracts\VersionProvider;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Cmsmaxinc\FilamentSystemVersions\Commands\CheckDependencyVersions;
use Cmsmaxinc\FilamentSystemVersions\Filament\Widgets\DependencyWidget;
use Joaopaulolndev\FilamentGeneralSettings\FilamentGeneralSettingsPlugin;
use ShuvroRoy\FilamentSpatieLaravelHealth\FilamentSpatieLaravelHealthPlugin;
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
                DependencyWidget::make(),
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
            // ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
            //     return $builder->groups([
            //         NavigationGroup::make('Website')
            //             ->items([

            //             ]),
            //     ]);
            // })
            // ->routes(FilamentMails::routes())
            ->plugins([
                ChatifyPlugin::make(),
                FilamentEmail::make(),
                FilamentMailLogPlugin::make(),
                FilamentMailsPlugin::make(),
                FilamentShortUrlPlugin::make(),
                FilamentOopsPlugin::make()->addEnvironment('local', 'Local', '#008000'),  // Add this line
                PhosphorIconReplacement::make(),
                FilamentErrorPagesPlugin::make(),
                FilamentEditProfilePlugin::make(),
                EmailTemplatesPlugin::make(),
                // BlogPlugin::make(),
                // Schedule::call(CheckDependencyVersions::class)->daily(),
                Blog::make(),
                FilamentAnnouncePlugin::make()
                    ->pollingInterval('30s') // optional, by default it is set to null
                    ->defaultColor(Color::Blue), // optional, by default it is set to "primary"
                // Impersonate::make(),
                // Impersonate::make('impersonate')
                //     ->guard('another-guard')
                //     ->redirectTo(route('some.other.route')),
                ActivitylogPlugin::make(),
                SpotlightPlugin::make(),
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
                FilamentLogManager::make(),
                GlobalSearchModalPlugin::make(),
                FilamentSpatieLaravelHealthPlugin::make(),
                BannerPlugin::make(),
                StickyHeaderPlugin::make()
                    ->floating()
                    ->colored(),
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
                FilamentPlugin::make(),
                WindPlugin::make()
                    ->windPrefix('contact-us')
                    ->windMiddleware(['web'])
                    ->defaultDepartmentId(1)
                    ->defaultStatus('NEW')
                    ->departmentResource()
                    ->windModels([
                        'Department' => \LaraZeus\Wind\Models\Department::class,
                        'Letter' => \LaraZeus\Wind\Models\Letter::class,
                    ])
                    ->uploadDisk('public')
                    ->uploadDirectory('logos')
                    ->navigationGroupLabel('Wind'),
                TutorialsPlugin::make(),
                SpatieLaravelTranslatablePlugin::make()
                    ->defaultLocales(['fr', 'en']),
                \Hasnayeen\Themes\ThemesPlugin::make(),
                    // ->registerTheme([Awesome::getName() => Awesome::class])
            ]);
    }
}

