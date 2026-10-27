---
description: "Typed helpers for common DSL, raw()/rawAggregation() as guaranteed fallback."
tags: [stretch, query-builder, aggregations, dsl]
kind: convention
---

# raw() Escape Hatches

Every builder area pairs typed helpers with a raw escape hatch, so no Elasticsearch feature is ever unreachable.

## Rules

- Typed helpers cover common DSL (`terms()`, `dateHistogram()`, `match()`, ...).
- `raw()` / `rawAggregation()` is the permanent fallback for long-tail structures and passes the array through verbatim.
- Add a typed helper when a pattern is used often; leave rare structures on `raw()` to keep the API small.
- Never block a feature behind "not implemented"; `raw()` always accepts it.

```php
$agg->raw('my_agg', ['filter' => [...], 'aggs' => [...]]);
$builder->rawAggregation('price_stats', ['stats' => ['field' => 'price']]);
```
