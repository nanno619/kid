---
paths:
  - '**'
---

# General

## Prefer superpowers-laravel skills over Boost laravel-best-practices
For Laravel work, activate the matching `superpowers-laravel:*` skill instead of the generic Boost `laravel-best-practices` skill (user preference — superpowers-laravel is more granular). Only fall back to `laravel-best-practices` if no superpowers-laravel skill covers the task.

Current stack (Laravel 13.24, Pest, Pint, MySQL, Tabler/Bootstrap frontend, no Sail/Nova/Horizon/AI SDK/pgvector), so these apply:
- Always: using-laravel-superpowers, bootstrap-check/runner-selection, daily-workflow, quality-checks, tdd-with-pest, brainstorming, write-plan, execute-plan
- Controllers/architecture: controller-cleanup, controller-tests, form-requests-and-validation, policies-and-authorization, interfaces-and-di, complexity-guardrails, constants-and-configuration, custom-helpers, strategy-pattern, template-method-and-plugins
- Database: migrations-and-factories, eloquent-relationships-and-loading, performance-eager-loading, performance-select-columns, data-chunking-large-datasets, transactions-and-consistency, performance-caching
- Frontend: blade-components-and-layouts (Blade+Tabler, not Livewire)
- API/hardening: api-resources-and-pagination, api-surface-evolution, rate-limiting-and-throttle, request-forgery-protection, filesystem-uploads-and-urls, exception-handling-and-logging, http-client-resilience
- Background: task-scheduling, queues-and-horizon

Not applicable until the stack changes: nova-resource-patterns, laravel-ai-sdk/ai-sdk-essentials, laravel-vector-search/vector-semantic-search, upgrade-13, horizon-metrics-and-dashboards, e2e-playwright, internationalization-and-translation, dependencies-trim-packages.
