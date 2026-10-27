---
description: "Cache key from sha1 of sorted build(), scoped by connection and index."
tags: [stretch, caching, redis, query-builder]
kind: convention
---

# Structural Cache Keys

The cache key is prefix + connection + indexes + `sha1(serialize(Arr::sortRecursive(build())))`, derived from the query's structure rather than a hand-written string.

## Rules

- `sortRecursive` normalizes clause and key order, so the same logical query always yields the same key.
- Keys are scoped by connection and index; identical queries on different connections or indexes never collide.
- The whole key is wrapped in a Redis cluster hash tag (`{...}`) so `flexible()` can MGET the key and its `illuminate:cache:flexible:created:` twin from one slot. Never drop the braces; clustered Redis rejects the cross-slot read.
- `build()` stays pure so the key can be computed independently of `execute()`.
- Any new state that changes query semantics flows through `build()`, or it will not affect the key and stale cache is served.

```php
public function getCacheKey(): string
{
    $sorted = Arr::sortRecursive($this->build());
    $hash = sha1(serialize($sorted));
    $indexes = $this->getIndexes()->implode(':');

    return '{'.$this->getCachePrefix().$this->getConnectionName().':'.$indexes.$hash.'}';
}
```

See [[fluent-builder]] and [[immutable-connection-switch]].
