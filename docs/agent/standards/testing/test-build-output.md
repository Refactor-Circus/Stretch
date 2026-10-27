---
description: "Query-shape tests use a bare builder and assert build() output, no client."
tags: [stretch, testing, query-builder]
kind: convention
---

# Test build() Output

Query-shape tests construct a bare builder with no client and assert on `build()`, never on a mocked dispatch.

## Why

- `build()` is pure ([[fluent-builder]]), so DSL-structure tests need neither Elasticsearch nor a mock: fast, deterministic, and isolated from dispatch tests.

## Rules

- Mock the client only when dispatch, wrapping or facade behavior is under test; see [[mock-client-contract]].
- Assert the exact DSL path, not just presence: `$query['query']['range']['created_at']['gte']`.
- Assert absence where it matters: `expect($query)->not->toHaveKey('track_total_hits')`.

```php
it('can create a match query', function () {
    $builder = new ElasticsearchQueryBuilder;   // no client
    $builder->match('title', 'Laravel');
    $query = $builder->build();
    expect($query['query']['match']['title']['query'])->toBe('Laravel');
});
```
