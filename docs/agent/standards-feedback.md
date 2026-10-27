# Standards Feedback

Every time work has to break a standard, add a row.

| Date | Spec | Standard | Deviation | Why |
| --- | --- | --- | --- | --- |
| 2026-10-23 | standards cleanup | errors/exceptions | `ElasticsearchManager::getConnectionConfig()` (`src/Domains/Connection/Services/ElasticsearchManager.php`) throws raw `\InvalidArgumentException` for a connection that is not configured or has no hosts (was agent-os `backend/config-safe-defaults`). | follow-up: add StretchException and throw subclasses (a `StretchException` already exists in `src/Exceptions/` but extends `Exception`, not `RuntimeException`, and has no subclasses) |
| 2026-10-23 | standards cleanup | errors/exceptions | `AggregationBuilder::build()` (`src/Domains/Aggregation/Builders/AggregationBuilder.php`) throws raw `LogicException` when `size()` is used on a non-terms aggregation or `orderBy()` on a type other than terms/histogram/date_histogram (was agent-os `backend/guard-builder-options`). | follow-up: add StretchException and throw subclasses (a `StretchException` already exists in `src/Exceptions/` but extends `Exception`, not `RuntimeException`, and has no subclasses) |
