<?php

declare(strict_types=1);

use Elastic\Elasticsearch\Client;
use RefactorCircus\Stretch\Domains\Connection\ConnectionServiceProvider;
use RefactorCircus\Stretch\Domains\Connection\Contracts\ClientContract;
use RefactorCircus\Stretch\Domains\Connection\Services\ElasticsearchClient;
use RefactorCircus\Stretch\Domains\Connection\Services\ElasticsearchManager;
use RefactorCircus\Stretch\Domains\DomainServiceProvider;
use RefactorCircus\Stretch\Domains\Query\Builders\ElasticsearchQueryBuilder;
use RefactorCircus\Stretch\Domains\Query\Builders\MultiQueryBuilder;
use RefactorCircus\Stretch\Domains\Query\Contracts\MultiQueryBuilderContract;
use RefactorCircus\Stretch\Domains\Query\Contracts\QueryBuilderContract;
use RefactorCircus\Stretch\Domains\Query\QueryServiceProvider;
use RefactorCircus\Stretch\Stretch;

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
