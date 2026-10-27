---
description: "connection() clones and swaps client instead of mutating in place."
tags: [stretch, query-builder, connections]
kind: convention
---

# Immutable Connection Switch

`connection()` clones the builder and swaps the client on the clone; it never mutates in place.

## Why

- It is the one exception to the mutate-and-return-`$this` rule of [[fluent-builder]]. Cloning lets one configured base builder branch to several connections without a switch clobbering earlier references or changing shared state mid-chain.

## Rules

- All accumulated state (query clauses, cache settings) survives the clone, so `connection()` is valid at any point in the chain.
- It requires `$this->manager` and throws when the manager is absent.
- `getConnectionName()` falls back as `$connectionName ?? manager default ?? 'default'`. The name feeds the cache key, so per-connection results never collide.

```php
$clone = clone $this;
$clone->client = new ElasticsearchClient($this->manager->connection($name));
$clone->connectionName = $name;

return $clone;
```

See [[structural-cache-keys]] for how the connection name scopes the cache key.
