---
description: "Mock ClientContract with Mockery; assert payload via m::on or literal ->with."
tags: [stretch, testing, mockery, client]
kind: convention
---

# Mock ClientContract

Dispatch tests mock `ClientContract` with Mockery and assert the outgoing payload.

## Rules

- Mock the `ClientContract` interface, never the native Elasticsearch client.
- Pin the call count with `->once()` (or `->twice()`).
- Pick the payload assertion by shape:
  - `m::on(fn ($params) => ...)` for search and delete bodies, checking only the keys that matter (tolerant of default `size`, `from`).
  - Literal `->with([...])` for small exact payloads (index, update, delete document operations).
- `andReturn()` a realistic response shape: `['hits' => ['total' => ..., 'hits' => []]]`, `['result' => 'created']`, `['deleted' => N]`.
- Use this only when dispatch is under test; for DSL shape see [[test-build-output]].

```php
$mockClient = m::mock(ClientContract::class);
$mockClient->shouldReceive('search')
    ->once()
    ->with(m::on(fn ($params) =>
        $params['index'] === 'posts'
        && isset($params['body']['query']['bool']['filter'])
    ))
    ->andReturn(['hits' => ['total' => ['value' => 0], 'hits' => []]]);

(new ElasticsearchQueryBuilder($mockClient))->index('posts')->/* ... */->execute();
```
