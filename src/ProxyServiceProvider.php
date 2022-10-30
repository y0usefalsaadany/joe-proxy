<?php

namespace Yousefpackage\JoeProxy;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Yousefpackage\JoeProxy\Repositories\DatabaseLogRepository;
use Yousefpackage\JoeProxy\Repositories\DatabaseAlertRepository;
use Yousefpackage\JoeProxy\Repositories\Contracts\LogRepository;
use Yousefpackage\JoeProxy\Repositories\Contracts\AlertRepository;

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

    /**
     * @throws BindingResolutionException
     */
    public function register()
    {
        // Binding contracts to repositories.
        foreach ($this->repositories as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
