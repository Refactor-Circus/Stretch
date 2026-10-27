---
description: 'Stretch override of the global test-layers standard: behavior tested once at the action, surfaces test only their own wiring, route names not URLs, layer table; TestCase bound in both Unit and Feature because unit tests of classes that read config, cache or the container need Testbench; Feature for facade/provider/service-wired behavior.'
tags:
  - testing
  - architecture
  - layers
  - testbench
kind: architectural
overrides: refactor-circus/standards
reviewed_hash: 1cf688063fa0
---
# Test Layers

Behavior is tested once, at the action; each surface tests only its own wiring.

## Layers

| Layer | Location | Invokes via | Covers |
|---|---|---|---|
| Unit | `tests/Unit/` | the class directly | One class's logic: builders and their `build()` output, value objects, client wrapping, the connection manager, caching |
| Actions | `tests/Feature/*ActionsTest.php` | `app({Action}::class)->execute(...)` | Business rules, edge cases, guards, events |
| HTTP | `tests/Feature/Http/` | `$this->postJson(route('{package}.…'))` | Status codes, validation mapping, authorization, JSON paths |
| Console | `tests/Feature/Console/` | `$this->artisan('{package}:…')` | Arguments, prompts, output, exit codes |
| Other surfaces | `tests/Feature/{Surface}/` | the surface's own entry point | Its envelope, errors, parity with HTTP |
| Architecture | `tests/ArchTest.php` | `arch()` | Structural rules ([[arch-tests]]) |

## Rules

- Do not repeat a business case per surface. A "cannot delete while in use" rule is one action test, not one per surface; the HTTP test only checks that the refusal maps to the right status.
- A surface test proves the surface reaches the action and shapes its result: routing, validation, authorization ([[authorization]]), status, and the resource payload ([[resources]]).
- HTTP tests refer to routes by name, never by literal URL ([[routes]]).
- Set up data with model factories. Shared fixtures (fake implementations, test policies, extra servers) live in `tests/Fixtures/`.

## Unit vs feature

Stretch differs from the global rule here: `tests/Unit/` is not framework-free.

- `TestCase` (Testbench; see [[testbench-harness]]) is bound in both `Unit` and `Feature`, because Stretch classes read config lazily ([[per-query-config-fallback]]), so many unit tests need a booted config repository even for a bare builder.
- A unit test may use what the boot provides only for the class under test's own dependencies: `config()` read by builder getters or `build()`, the cache store behind `Cacheable`, the container that `ElasticsearchManager` resolves and purges. It still instantiates the class directly (`new ElasticsearchQueryBuilder(...)`, a mocked `ClientContract`) and never goes through the `Stretch` facade or the service provider.
- `tests/Feature/` is for behavior wired by the package boot: the `Stretch` facade and root, `StretchServiceProvider` bindings and publishing, multiple configured connections.
- A test that needs no config, cache or container still belongs in `Unit`; it just does not use the boot.

```php
// tests/Pest.php
uses(TestCase::class)->in('Feature');
uses(TestCase::class)->in('Unit'); // Stretch unit tests read config, cache and the container
```

## Reference implementation (Refactor Circus)

`RefactorCircus\Keystone\Testing\Parity::gaps()` lists actions a surface cannot reach, so a parity test can assert every action is offered on each surface the package has.
