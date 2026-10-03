<?php

declare(strict_types=1);

namespace JayI\Stretch\Domains\Query;

use Illuminate\Support\ServiceProvider;
use JayI\Stretch\Domains\Query\Builders\ElasticsearchQueryBuilder;
use JayI\Stretch\Domains\Query\Builders\MultiQueryBuilder;
use JayI\Stretch\Domains\Query\Contracts\MultiQueryBuilderContract;
use JayI\Stretch\Domains\Query\Contracts\QueryBuilderContract;

/**
 * Binds the query builder contracts to their Elasticsearch implementations
 * for dependency injection support.
 */
class QueryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(QueryBuilderContract::class, ElasticsearchQueryBuilder::class);
        $this->app->bind(MultiQueryBuilderContract::class, MultiQueryBuilder::class);
    }
}
