<?php

declare(strict_types=1);

namespace RefactorCircus\Stretch\Domains\Connection;

use Elastic\Elasticsearch\Client;
use Illuminate\Support\ServiceProvider;
use RefactorCircus\Stretch\Domains\Connection\Contracts\ClientContract;
use RefactorCircus\Stretch\Domains\Connection\Services\ElasticsearchClient;
use RefactorCircus\Stretch\Domains\Connection\Services\ElasticsearchManager;

/**
 * Registers the Elasticsearch connection services.
 *
 * Registers the ElasticsearchManager for multi-connection support,
 * the default Elasticsearch client, and the ClientContract binding.
 * This setup enables both single and multi-connection usage patterns.
 */
class ConnectionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register the Elasticsearch connection manager as a singleton
        // This manager handles multiple named connections and lazy loading
        $this->app->singleton('elasticsearch.manager', function ($app): ElasticsearchManager {
            return new ElasticsearchManager($app);
        });

        // Register the default Elasticsearch client
        // Uses the connection manager to get the default connection
        $this->app->singleton(Client::class, function ($app): Client {
            return $app['elasticsearch.manager']->connection();
        });

        // Register the client contract binding
        // Wraps the native Elasticsearch client with our contract implementation
        $this->app->singleton(ClientContract::class, function ($app): ClientContract {
            return new ElasticsearchClient($app[Client::class]);
        });
    }
}
