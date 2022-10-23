<?php

namespace Yousefpackage\JoeProxy;

use Illuminate\Support\ServiceProvider;
use Yousefpackage\JoeProxy\Repositories\Contracts\AlertRepository;
use Yousefpackage\JoeProxy\Repositories\Contracts\LogRepository;
use Yousefpackage\JoeProxy\Repositories\DatabaseAlertRepository;
use Yousefpackage\JoeProxy\Repositories\DatabaseLogRepository;

class ProxyServiceProvider extends ServiceProvider
{

    /**
     * Service's repositories mappings.
     *
     * @var array|string[]
     */
    protected array $repositories = [
        LogRepository::class    => DatabaseLogRepository::class,
        AlertRepository::class  => DatabaseAlertRepository::class
    ];

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'joeProxy');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    public function register()
    {
        // Binding contracts to repositories.
        foreach ($this->repositories as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
