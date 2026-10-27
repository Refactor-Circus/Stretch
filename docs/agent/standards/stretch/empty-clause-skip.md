---
description: "Skip attaching callback clauses that add no query, avoiding invalid ES DSL."
tags: [stretch, query-builder, elasticsearch, dsl]
kind: convention
---

# Empty-Clause Skip

A composite clause that receives a callback skips attachment when the callback adds no query.

## Why

- An empty `bool`, `nested` or `filter` clause makes Elasticsearch reject the whole request. Skipping keeps requests valid when a callback conditionally adds nothing.

## Rules

- Build the sub-query, read `build()['query'] ?? null`, and return early on `null`.
- Applies to `nested()`, `filter()`, `postFilter()`, and `BoolQueryBuilder` must/should/filter/mustNot (through `buildSubQuery()`).
- Every new composite or callback clause follows this. Never emit `{"bool": {}}` or a `nested` with no query.

```php
$sub = new ElasticsearchQueryBuilder;
$callback($sub);
$query = $sub->build()['query'] ?? null;
if ($query === null) {
    return $this; // never attach an empty clause
}
```
