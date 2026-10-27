---
description: "TestCase extends Orchestra with WithWorkbench; config set inline in beforeEach; array cache store."
tags: [stretch, testing, testbench]
kind: convention
---

# Testbench Harness

How the Testbench `TestCase` is set up and fed config. Which tests may boot it is in [[test-layers]].

## Rules

- `tests/TestCase.php` extends `Orchestra\Testbench\TestCase` and uses `WithWorkbench`.
- There is no published config under Testbench. Set every key the code under test reads in `beforeEach`, so each test gets deterministic, isolated values.
- Use the `array` cache store in tests: no filesystem, no leakage between tests.

```php
beforeEach(function () {
    config(['stretch.cache.enabled' => false]);
    config(['stretch.cache.store' => 'array']);
});
```

Relates to [[per-query-config-fallback]]: the getters these tests exercise fall back to this config.
