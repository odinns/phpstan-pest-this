# Repository Guidelines

## Project Shape
- This is a small PHPStan extension package for Pest.
- The extension infers Pest closure `$this` types from `pestClosureThisTypeMap` path mappings.
- Keep changes narrow. This package should stay boring: no framework glue, no runtime Pest behavior, no broad test-suite magic.

## Important Files
- `src/PestClosureThisTypeResolver.php` contains path-to-class mapping resolution.
- `src/PestFunctionParameterClosureThisExtension.php` handles Pest function calls like `it()`, `test()`, `beforeEach()`, and `afterEach()`.
- `src/PestMethodParameterClosureThisExtension.php` handles fluent hook calls like `uses(...)->beforeEach()`.
- `extension.neon` wires the PHPStan services and parameters.
- `tools/generate-pest-proxy.php` generates static-analysis-only proxy test cases for protected helper methods.
- `tests/PestClosureThisTypeResolverTest.php` covers resolver behavior.

## Commands
- Install dependencies: `composer install`
- Run the full check suite: `composer check`
- Run tests only: `composer test`
- Run PHPStan directly: `vendor/bin/phpstan analyse src tools --level=max --no-progress`

## Coding Rules
- PHP 8.2 and up.
- Use strict types.
- Prefer small, explicit conditionals over clever abstraction.
- Preserve first-match-wins behavior for `pestClosureThisTypeMap`.
- Normalize file paths before matching when touching resolver logic.
- Avoid adding dependencies unless the alternative is genuinely worse.

## Testing
- Add or update focused PHPUnit tests for behavior changes.
- Keep tests close to the changed behavior. This repo does not need a cathedral for every brick.
- Run `composer check` before considering the work done.

## Documentation
- Update `README.md` when user-facing configuration, behavior, supported Pest calls, or generator usage changes.
- Update `CHANGELOG.md` for behavior changes worth releasing.
- Keep examples copy-pasteable and aligned with `extension.neon`.

## Release Notes
- `RELEASING.md` contains the release flow.
- Do not edit package metadata casually; Composer package fields are part of the public surface.
