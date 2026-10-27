---
description: "Pest it() behavior phrases with fluent expect()->and() chains; ->throws for exceptions."
tags: [stretch, testing, pest]
kind: convention
---

# Pest Style

Tests are Pest `it()` closures named with a behavior phrase and asserted through fluent `expect()` chains.

## Rules

- `it('<behavior phrase>', fn)`; no PHPUnit test classes or methods, no `describe` blocks.
- Chain related assertions with `->and(...)` off one `expect()`; separate `expect()` calls are fine for unrelated ones.
- Assert exact values with `->toBe()`; presence and absence with `->toHaveKey()` / `->not->toHaveKey()`.
- Expected exceptions use the trailing modifier: `it('throws when ...', fn () => ...)->throws(RuntimeException::class);`

```php
it('wraps query in body when executing', function () {
    // ...
    expect($query['query']['multi_match']['query'])->toBe('laptop for work')
        ->and($query['query']['multi_match']['fields'])->toBe(['title^3']);
});
```
