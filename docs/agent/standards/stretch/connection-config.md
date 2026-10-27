---
description: "Connection config: missing/empty connection throws a StretchException subclass; ssl_verification ?? true; timeouts only when declared."
tags: [stretch, config, connections, security]
kind: convention
---

# Connection Config

Complements [[configuration]] for the `stretch.connections` entries that `ElasticsearchManager` turns into clients.

## Rules

- A missing connection, or one with empty `hosts`, throws right away with the connection name in `[…]`. It throws a `StretchException` subclass per [[exceptions]], not `InvalidArgumentException`.
- SSL verification defaults on: read `$config['ssl_verification'] ?? true` and only call `setSSLVerification(false)` when a connection turns it off explicitly.
- Optional HTTP hardening (`connect_timeout`, `timeout`) is passed only when the connection declares it. `array_filter` the nulls out, so an absent key never overrides the client's own default.

```php
if (! ($config['ssl_verification'] ?? true)) {
    $clientBuilder->setSSLVerification(false);
}

$httpOptions = array_filter([
    'connect_timeout' => $config['connect_timeout'] ?? null,
    'timeout' => $config['timeout'] ?? null,
]);
```
