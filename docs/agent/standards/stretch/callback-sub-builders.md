---
description: "Composite clauses use a fresh sub-builder; parent extracts build() result."
tags: [stretch, query-builder, sub-builders]
kind: convention
---

# Callback Sub-Builders

Composite clauses take a callback that receives a fresh builder, and the parent reads only that builder's built result.

## Why

- Sub-query state stays isolated from the parent; nothing leaks across clause boundaries.

## Rules

- Query-context clauses (`nested`, `filter`, `postFilter`) pass `$this->client, $this->manager`, so connection context carries into the sub-builder.
- Pure structural sub-builders build without executing and need no client: `BoolQueryBuilder` (`new ElasticsearchQueryBuilder`), `AggregationBuilder`, `RetrieverBuilder`.
- The parent reads `$sub->build()['query']` (or `->build()` for aggregations and retrievers), never the sub-builder's internals.
- A new composite clause gets its own builder class implementing its contract; clause assembly is never inlined in the main builder.

```php
public function nested(string $path, callable $callback): static
{
    $sub = new ElasticsearchQueryBuilder($this->client, $this->manager);
    $callback($sub);
    $query = $sub->build()['query'] ?? null;
    // ...attach (see empty-clause-skip)
}
```

See [[empty-clause-skip]] for the null-skip rule on the extracted query.
