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

        $query = $this->queryBuilder();
        foreach ($this->repositories as $repository) {
            $this->app->afterResolving($repository, function ($instance) use($query) {
                $instance->setQuery($query);
            });
        }
    }

    /**
     * @throws BindingResolutionException
     */
    private function queryBuilder(): Builder
    {
        /** @var ConnectionResolverInterface $connectionInterface */
        $connectionInterface = $this->app->make(ConnectionResolverInterface::class);

        return $connectionInterface
            ->connection()
            ->table('proxy_key_value_storage')
            ->newQuery()
            ->where('key');
    }
}
