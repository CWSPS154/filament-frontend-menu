<?php
/*
 * Copyright CWSPS154. All rights reserved.
 * @auth CWSPS154
 * @link  https://github.com/CWSPS154
 */

declare(strict_types=1);

namespace CWSPS154\FilamentFrontendMenu;

use CWSPS154\FilamentFrontendMenu\Database\Seeders\DatabaseSeeder;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentFrontendMenuServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-frontend-menu';

    public function configurePackage(Package $package): void
    {
        $package->name(self::$name)
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasMigrations(
                [
                    'create_menus'
                ]
            )
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->startWith(function (InstallCommand $command) {
                        $command->info('Hi Mate, Thank you for installing My Package!');
                    })
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->endWith(function (InstallCommand $command) {
                        if ($command->confirm('Do you wish to run the seeder for cwsps154/filament-users-roles-permissions ?')) {
                            $command->comment('The seeder is filled with "admin" as panel id, please check the route name for your panel');
                            $command->comment('Running seeder...');
                            $command->call('db:seed', [
                                'class' => DatabaseSeeder::class
                            ]);
                        }
                        $command->info('I hope this package will help you to manage frontend menu\'s');
                    })
                    ->askToStarRepoOnGitHub('CWSPS154/filament-frontend-menu');
            });
    }

    public function boot(): FilamentFrontendMenuServiceProvider
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/vendor/filament-tree', 'filament-tree');
        require_once __DIR__ . '/helper.php';
        return parent::boot();
    }
}
