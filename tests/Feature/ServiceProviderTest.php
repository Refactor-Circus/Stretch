<?php

declare(strict_types=1);

use Elastic\Elasticsearch\Client;
use JayI\Stretch\Domains\Connection\ConnectionServiceProvider;
use JayI\Stretch\Domains\Connection\Contracts\ClientContract;
use JayI\Stretch\Domains\Connection\Services\ElasticsearchClient;
use JayI\Stretch\Domains\Connection\Services\ElasticsearchManager;
use JayI\Stretch\Domains\DomainServiceProvider;
use JayI\Stretch\Domains\Query\Builders\ElasticsearchQueryBuilder;
use JayI\Stretch\Domains\Query\Builders\MultiQueryBuilder;
use JayI\Stretch\Domains\Query\Contracts\MultiQueryBuilderContract;
use JayI\Stretch\Domains\Query\Contracts\QueryBuilderContract;
use JayI\Stretch\Domains\Query\QueryServiceProvider;
use JayI\Stretch\Stretch;

it('registers the domain service providers', function () {
    expect(app()->getProvider(DomainServiceProvider::class))->not->toBeNull()
        ->and(app()->getProvider(ConnectionServiceProvider::class))->not->toBeNull()
        ->and(app()->getProvider(QueryServiceProvider::class))->not->toBeNull();
});

it('binds the connection services', function () {
    expect(app('elasticsearch.manager'))->toBeInstanceOf(ElasticsearchManager::class)
        ->and(app(Client::class))->toBeInstanceOf(Client::class)
        ->and(app(ClientContract::class))->toBeInstanceOf(ElasticsearchClient::class);
});

it('binds the query builder contracts', function () {
    expect(app(QueryBuilderContract::class))->toBeInstanceOf(ElasticsearchQueryBuilder::class)
        ->and(app(MultiQueryBuilderContract::class))->toBeInstanceOf(MultiQueryBuilder::class);
});

it('binds the stretch service behind the facade', function () {
    expect(app('stretch'))->toBeInstanceOf(Stretch::class);
});
