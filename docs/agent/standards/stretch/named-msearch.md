---
description: "MultiQueryBuilder sorts keys at build and remap so names pair to positional responses."
tags: [stretch, multi-search, msearch, elasticsearch]
kind: convention
---

# Named msearch

`MultiQueryBuilder` sorts query names the same way at build and at remap, so each name pairs with its positional `_msearch` response.

## Why

- `_msearch` returns a positional `responses[]` array. Identical sorting in both places lines each name up with its own result and makes the cache key order-independent.

## Rules

- `build()` calls `sortKeys()` before emitting header/body pairs; `execute()` remaps the positional responses onto the same sorted names.
- `add($name, ...)` uses `$name` as the index when the sub-query sets none (`getIndex() ?? $name`).
- Callers read results by name: `$results['responses']['posts']`.
- An empty builder short-circuits: `execute()` returns `['responses' => []]` without calling Elasticsearch.
- Any change to build ordering is mirrored in the remap, or names and results desync silently.

```php
// build()
$queries = collect($this->queries)->sortKeys()->toArray();

// execute()
$key = -1;
$results['responses'] = collect($this->queries)->sortKeys()->map(function () use (&$results, &$key) {
    $key++;
    return Arr::get($results, "responses.{$key}");
})->toArray();
```

See [[structural-cache-keys]]: the sorted `build()` keeps the multi-query cache key stable.
