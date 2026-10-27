---
description: "Nullable settings resolved as per-query value ?? config default, lazily in getters."
tags: [stretch, config, query-builder, caching]
kind: convention
---

# Per-Query Config Fallback

Complements [[configuration]]: builder settings are stored nullable and resolved lazily in their getters.

## Rules

- A setting property is nullable; `null` means untouched and falls back to config.
- The setter stores the raw value; the getter applies `per-query ?? config(...)`. Never default eagerly in the constructor: the builder may exist before or outside a booted app.
- The pattern covers every cache setting: enabled, ttl, prefix, store.
- Provide a bare-verb alias where it reads well: `cache()` for `setCacheEnabled()`, `clearCache()` for `setCacheClear()`.

```php
protected ?bool $cacheEnabled = null;

public function getCacheEnabled(): bool
{
    return $this->cacheEnabled ?? (bool) config('stretch.cache.enabled', false);
}
```
