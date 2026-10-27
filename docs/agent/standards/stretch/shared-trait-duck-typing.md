---
description: "Shared traits detect host shape via method_exists/property_exists, not an interface."
tags: [stretch, traits, caching]
kind: convention
---

# Shared Trait Duck-Typing

A shared trait detects its host's shape at runtime with `method_exists`/`property_exists` instead of requiring an interface.

## Where

- `IsCacheable` serves two differently shaped hosts: `ElasticsearchQueryBuilder` (a single `getIndex()`) and `MultiQueryBuilder` (a `queries` array), without forcing a common contract on either.

## Rules

- Use it only when one trait must adapt to hosts with genuinely divergent shapes; each branch handles one host's structure.
- When hosts share a real contract, use an interface or abstract method instead.
- PHPStan narrows these checks as always-true per host; suppress with `@phpstan-ignore function.alreadyNarrowedType` on the check.

```php
if (method_exists($this, 'getIndex')) {
    $indexes = $indexes->push($this->getIndex());
}

if (property_exists($this, 'queries')) {
    $indexes = collect($this->queries)->pluck('index');
}
```
