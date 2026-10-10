# Changelog

All notable changes to `refactor-circus/stretch` are documented in this file.

## [Unreleased](https://github.com/Refactor-Circus/Stretch/commits/main)

### Breaking

- Moved to the Refactor Circus organisation: the package is now `refactor-circus/stretch` with the PHP namespace `RefactorCircus\Stretch` (it was `jayi/stretch` and `JayI\Stretch`). Update `composer.json` requirements and `use` statements. Old class names are not kept as aliases, so stored values written under them - polymorphic `*_type` columns, audit subjects, Pennant feature names - need updating to the new names.
Source code is reorganised into domain modules under `src/Domains/{Connection,Query,Aggregation}`, mirroring the mono domain-module standard. Classes moved namespace; there are no aliases for the old names. `RefactorCircus\Stretch\Stretch`, `RefactorCircus\Stretch\Facades\Stretch`, `RefactorCircus\Stretch\Exceptions\StretchException` and `RefactorCircus\Stretch\StretchServiceProvider` are unchanged, as are the config file, its keys, and the `stretch` / `elasticsearch.manager` container bindings.

| Old class | New class |
|-----------|-----------|
| `RefactorCircus\Stretch\ElasticsearchManager` | `RefactorCircus\Stretch\Domains\Connection\Services\ElasticsearchManager` |
| `RefactorCircus\Stretch\Client\ElasticsearchClient` | `RefactorCircus\Stretch\Domains\Connection\Services\ElasticsearchClient` |
| `RefactorCircus\Stretch\Contracts\ClientContract` | `RefactorCircus\Stretch\Domains\Connection\Contracts\ClientContract` |
| `RefactorCircus\Stretch\Builders\Concerns\SwitchesConnections` | `RefactorCircus\Stretch\Domains\Connection\Concerns\SwitchesConnections` |
| `RefactorCircus\Stretch\Builders\ElasticsearchQueryBuilder` | `RefactorCircus\Stretch\Domains\Query\Builders\ElasticsearchQueryBuilder` |
| `RefactorCircus\Stretch\Builders\BoolQueryBuilder` | `RefactorCircus\Stretch\Domains\Query\Builders\BoolQueryBuilder` |
| `RefactorCircus\Stretch\Builders\RangeQueryBuilder` | `RefactorCircus\Stretch\Domains\Query\Builders\RangeQueryBuilder` |
| `RefactorCircus\Stretch\Builders\FunctionScoreBuilder` | `RefactorCircus\Stretch\Domains\Query\Builders\FunctionScoreBuilder` |
| `RefactorCircus\Stretch\Builders\SpanQueryBuilder` | `RefactorCircus\Stretch\Domains\Query\Builders\SpanQueryBuilder` |
| `RefactorCircus\Stretch\Builders\SuggestBuilder` | `RefactorCircus\Stretch\Domains\Query\Builders\SuggestBuilder` |
| `RefactorCircus\Stretch\Builders\RetrieverBuilder` | `RefactorCircus\Stretch\Domains\Query\Builders\RetrieverBuilder` |
| `RefactorCircus\Stretch\Builders\MultiQueryBuilder` | `RefactorCircus\Stretch\Domains\Query\Builders\MultiQueryBuilder` |
| `RefactorCircus\Stretch\Builders\ScrollBuilder` | `RefactorCircus\Stretch\Domains\Query\Builders\ScrollBuilder` |
| `RefactorCircus\Stretch\Builders\Concerns\IsCacheable` | `RefactorCircus\Stretch\Domains\Query\Concerns\IsCacheable` |
| `RefactorCircus\Stretch\Builders\Concerns\TracksLastQuery` | `RefactorCircus\Stretch\Domains\Query\Concerns\TracksLastQuery` |
| `RefactorCircus\Stretch\Contracts\QueryBuilderContract` | `RefactorCircus\Stretch\Domains\Query\Contracts\QueryBuilderContract` |
| `RefactorCircus\Stretch\Contracts\BoolQueryBuilderContract` | `RefactorCircus\Stretch\Domains\Query\Contracts\BoolQueryBuilderContract` |
| `RefactorCircus\Stretch\Contracts\RangeQueryBuilderContract` | `RefactorCircus\Stretch\Domains\Query\Contracts\RangeQueryBuilderContract` |
| `RefactorCircus\Stretch\Contracts\MultiQueryBuilderContract` | `RefactorCircus\Stretch\Domains\Query\Contracts\MultiQueryBuilderContract` |
| `RefactorCircus\Stretch\Pagination\ElasticPaginator` | `RefactorCircus\Stretch\Domains\Query\Support\ElasticPaginator` |
| `RefactorCircus\Stretch\Builders\AggregationBuilder` | `RefactorCircus\Stretch\Domains\Aggregation\Builders\AggregationBuilder` |
| `RefactorCircus\Stretch\Contracts\AggregationBuilderContract` | `RefactorCircus\Stretch\Domains\Aggregation\Contracts\AggregationBuilderContract` |

### Added

- `RefactorCircus\Stretch\Domains\DomainServiceProvider`, `Domains\Connection\ConnectionServiceProvider` and `Domains\Query\QueryServiceProvider`, which now hold the container bindings previously registered directly by `StretchServiceProvider`.

### Changed

- Supports PHP 8.3 to 8.5 on Laravel 12 and 13, tested across that matrix in CI. PHP 8.3 installs Pest 4; PHP 8.4 and later can use Pest 5.
