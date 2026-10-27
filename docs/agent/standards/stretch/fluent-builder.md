---
description: "Chainable static-returning methods; build() assembles, execute() sends; single-clause unwrap."
tags: [stretch, query-builder, fluent]
kind: convention
---

# Fluent Builder

Builder methods record state and return `static`; `build()` assembles the body and `execute()` sends it.

## Chaining

- Every clause or option method returns `$this` (typed `static`). Sub-builder entry points (`range()`, `bool()` without a callback) return the sub-builder instead.
- State lives in typed protected arrays and scalars (`$query`, `$aggregations`, `$sort`, `$size`, ...). Methods append; nothing reaches Elasticsearch until `execute()`.

## build() and execute()

- `build()` is pure: it assembles and returns the array body with no side effects. `toArray()` is its alias for inspection.
- `execute()` calls `build()`, wraps it in `['index' => ..., 'body' => ...]`, stores `$lastQuery` and dispatches through the client.
- Precedence in `build()`: `retriever` replaces query and knn entirely (early return); else top-level `knn`; else the query (with `filters` wrapped in `bool.filter`).

## Single-clause unwrap

- A lone clause is emitted bare; only multiple clauses wrap in `bool.must`, so a single `match` reads like hand-written DSL.

```php
count($this->query) === 1
    ? $body['query'] = $this->query[0]              // { "match": {...} }
    : $body['query'] = ['bool' => ['must' => $this->query]];
```
