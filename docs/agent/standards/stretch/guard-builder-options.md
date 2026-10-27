---
description: "AggregationBuilder::build() throws a StretchException subclass when size()/orderBy() hit an unsupported type; terms size clamped to max_buckets."
tags: [stretch, aggregations, builders, errors]
kind: convention
---

# Guard Builder Options

When a builder option only applies to certain aggregation types, `build()` rejects misuse instead of silently dropping it.

## Why

- A silently ignored option hides a coding mistake. Failing at build time with a clear message beats a cryptic Elasticsearch parse error later.

## Rules

- An option used on an unsupported type throws a `StretchException` subclass per [[exceptions]], never a raw `LogicException`.
- Validate in `build()`, not in the setter: the setter does not yet know the final aggregation type.
- The message names the offending option and the actual type, from `$this->aggregationType()`, wrapped in `[…]`.
- `size()` is supported on `terms` only.
- `orderBy()` is supported on `terms`, `histogram` and `date_histogram` only.
- A `terms` aggregation always gets a clamped size: `min(size ?? stretch.aggregations.default_size, stretch.aggregations.max_buckets)`, so bucket explosion is capped by default, even when `size()` was never called.

```php
if (isset($agg['terms'])) {
    $agg['terms']['size'] = min(
        $this->size ?? config('stretch.aggregations.default_size'),
        config('stretch.aggregations.max_buckets'),
    );
} elseif ($this->size !== null) {
    throw UnsupportedAggregationOptionException::forOption('size()', $this->aggregationType());
}
```

The exception class name above is illustrative until the follow-up in `docs/agent/standards-feedback.md` lands.
