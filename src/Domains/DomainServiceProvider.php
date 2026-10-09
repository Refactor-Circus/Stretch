<?php

declare(strict_types=1);

namespace RefactorCircus\Stretch\Domains;

use Illuminate\Support\ServiceProvider;
use RefactorCircus\Stretch\Domains\Connection\ConnectionServiceProvider;
use RefactorCircus\Stretch\Domains\Query\QueryServiceProvider;

/**
 * Registers every Stretch domain service provider.
 *
 * The Aggregation domain has no container bindings of its own (its builder
 * is created by the query builder), so it has no provider.
 */
class DomainServiceProvider extends ServiceProvider
{
    /**
     * The domain service providers.
     *
     * @var array<int, class-string<ServiceProvider>>
     */
    private array $providers = [
        ConnectionServiceProvider::class,
        QueryServiceProvider::class,
    ];

    public function register(): void
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }
}
