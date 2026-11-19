<?php

namespace Modules\Asset\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class AssetServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Asset';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'asset';

    /**
     * Command classes to register.
     *
     * @var string[]
     */
    // protected array $commands = [];

    /**
     * Provider classes to register.
     *
     * @var string[]
     */
    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    /**
     * Define module schedules.
     * 
     * @param $schedule
     */
    // protected function configureSchedules(Schedule $schedule): void
    // {
    //     $schedule->command('inspire')->hourly();
    // }

public function register(): void
{
    parent::register();

    $this->app->bind(
        \Modules\Asset\Repositories\AssetRepositoryInterface::class,
        \Modules\Asset\Repositories\AssetRepository::class
    );
}



    }
