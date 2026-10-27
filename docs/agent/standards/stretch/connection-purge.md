---
description: "Manager lazy-builds/caches clients by name; purge forgets container singletons."
tags: [stretch, connections, container, octane]
kind: convention
---

# Connection Purge

Complements [[container-bindings]]: `ElasticsearchManager` names exactly which singletons a purge forgets.

## Rules

- `purge($name)` and `disconnect()` clear `$connections[$name]` and call `forgetInstance()` on `Client::class`, `ClientContract::class` and `'stretch'`.
- `forgetInstance()` is guarded by `method_exists($this->app, ...)`, so it is a no-op outside a full Laravel container (see [[shared-trait-duck-typing]]).
