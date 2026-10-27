---
description: "Parse ES responses with data_get defaults; handle both hits.total int and object forms."
tags: [stretch, elasticsearch, pagination, responses]
kind: convention
---

# Tolerate Response Shapes

Parse Elasticsearch responses defensively with `data_get` defaults, accepting both forms of `hits.total`.

## Why

- `hits.total` is an object (`{value, relation}`) by default but a bare int under `rest_total_hits_as_int`; pagination works under both and never crashes on a missing key.

## Rules

- Read nested values with `data_get($response, 'a.b.c', $default)`, never `$response['a']['b']`.
- Normalize the total: `is_array($total) ? $total['value'] ?? 0 : (int) $total`.
- Derive the current page from the builder's `from`/`size` (`floor(from / size) + 1`), guarding a `0` or `null` size.

```php
$total = data_get($response, 'hits.total', 0);

return new ElasticPaginator(
    items: data_get($response, 'hits.hits', []),
    total: is_array($total) ? ($total['value'] ?? 0) : (int) $total,
    perPage: $size ?: config('stretch.query.default_size'),
    currentPage: $size ? (int) floor($request->getFrom() / $size) + 1 : 1,
);
```
