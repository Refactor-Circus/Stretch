# Changelog

All notable changes to `jayi/stretch` are documented in this file.

## [Unreleased]

### Breaking

Source code is reorganised into domain modules under `src/Domains/{Connection,Query,Aggregation}`, mirroring the mono domain-module standard. Classes moved namespace; there are no aliases for the old names. `JayI\Stretch\Stretch`, `JayI\Stretch\Facades\Stretch`, `JayI\Stretch\Exceptions\StretchException` and `JayI\Stretch\StretchServiceProvider` are unchanged, as are the config file, its keys, and the `stretch` / `elasticsearch.manager` container bindings.

| Old class | New class |
|-----------|-----------|
| `JayI\Stretch\ElasticsearchManager` | `JayI\Stretch\Domains\Connection\Services\ElasticsearchManager` |
| `JayI\Stretch\Client\ElasticsearchClient` | `JayI\Stretch\Domains\Connection\Services\ElasticsearchClient` |
| `JayI\Stretch\Contracts\ClientContract` | `JayI\Stretch\Domains\Connection\Contracts\ClientContract` |
| `JayI\Stretch\Builders\Concerns\SwitchesConnections` | `JayI\Stretch\Domains\Connection\Concerns\SwitchesConnections` |
| `JayI\Stretch\Builders\ElasticsearchQueryBuilder` | `JayI\Stretch\Domains\Query\Builders\ElasticsearchQueryBuilder` |
| `JayI\Stretch\Builders\BoolQueryBuilder` | `JayI\Stretch\Domains\Query\Builders\BoolQueryBuilder` |
| `JayI\Stretch\Builders\RangeQueryBuilder` | `JayI\Stretch\Domains\Query\Builders\RangeQueryBuilder` |
| `JayI\Stretch\Builders\FunctionScoreBuilder` | `JayI\Stretch\Domains\Query\Builders\FunctionScoreBuilder` |
| `JayI\Stretch\Builders\SpanQueryBuilder` | `JayI\Stretch\Domains\Query\Builders\SpanQueryBuilder` |
| `JayI\Stretch\Builders\SuggestBuilder` | `JayI\Stretch\Domains\Query\Builders\SuggestBuilder` |
| `JayI\Stretch\Builders\RetrieverBuilder` | `JayI\Stretch\Domains\Query\Builders\RetrieverBuilder` |
| `JayI\Stretch\Builders\MultiQueryBuilder` | `JayI\Stretch\Domains\Query\Builders\MultiQueryBuilder` |
| `JayI\Stretch\Builders\ScrollBuilder` | `JayI\Stretch\Domains\Query\Builders\ScrollBuilder` |
| `JayI\Stretch\Builders\Concerns\IsCacheable` | `JayI\Stretch\Domains\Query\Concerns\IsCacheable` |
| `JayI\Stretch\Builders\Concerns\TracksLastQuery` | `JayI\Stretch\Domains\Query\Concerns\TracksLastQuery` |
| `JayI\Stretch\Contracts\QueryBuilderContract` | `JayI\Stretch\Domains\Query\Contracts\QueryBuilderContract` |
| `JayI\Stretch\Contracts\BoolQueryBuilderContract` | `JayI\Stretch\Domains\Query\Contracts\BoolQueryBuilderContract` |
| `JayI\Stretch\Contracts\RangeQueryBuilderContract` | `JayI\Stretch\Domains\Query\Contracts\RangeQueryBuilderContract` |
| `JayI\Stretch\Contracts\MultiQueryBuilderContract` | `JayI\Stretch\Domains\Query\Contracts\MultiQueryBuilderContract` |
| `JayI\Stretch\Pagination\ElasticPaginator` | `JayI\Stretch\Domains\Query\Support\ElasticPaginator` |
| `JayI\Stretch\Builders\AggregationBuilder` | `JayI\Stretch\Domains\Aggregation\Builders\AggregationBuilder` |
| `JayI\Stretch\Contracts\AggregationBuilderContract` | `JayI\Stretch\Domains\Aggregation\Contracts\AggregationBuilderContract` |

### Added

- `JayI\Stretch\Domains\DomainServiceProvider`, `Domains\Connection\ConnectionServiceProvider` and `Domains\Query\QueryServiceProvider`, which now hold the container bindings previously registered directly by `StretchServiceProvider`.
