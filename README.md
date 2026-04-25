# phpstan-pest-this

PHPStan extensions that infer Pest closure `$this` type from configurable test-path mappings.

## Why

Pest binds test closures at runtime, while PHPStan analyzes code statically.
Without extra help, closure `$this` is commonly inferred as `PHPUnit\Framework\TestCase`, which can produce false positives in Pest suites.

## Installation

```bash
composer require --dev odinns/phpstan-pest-this
```

## Quick setup

Add the extension to your PHPStan config:

```neon
includes:
    - vendor/odinns/phpstan-pest-this/extension.neon
```

The extension does not provide default test case mappings. Configure how file paths map to your Pest base test case classes:

```neon
parameters:
    pestClosureThisTypeMap:
        -
            pathContains: '/tests/'
            class: Tests\TestCase
```

This is the common Laravel/Pest setup where feature and unit tests share `Tests\TestCase`.

If your project uses separate base test cases, map the more specific paths explicitly:

```neon
parameters:
    pestClosureThisTypeMap:
        -
            pathContains: '/tests/Feature/'
            class: Tests\Feature\TestCase
        -
            pathContains: '/tests/Unit/'
            class: Tests\Unit\TestCase
```

`pathContains` is a substring match against the analyzed file path. The first matching mapping wins.

## Supported Pest calls

- Function calls: `it(...)`, `test(...)`, `beforeEach(...)`, `afterEach(...)`
- Fluent hooks: `uses(...)->beforeEach(...)`, `uses(...)->afterEach(...)`

## Optional: Generate a PHPStan proxy test case

If your base test case has protected assertion helpers, PHPStan may flag visibility errors from Pest closures.
Use the included generator to create a static-analysis-only proxy class with public wrappers.

After installation:

```bash
vendor/bin/generate-pest-proxy.php \
  --source="Tests\\Feature\\TestCase" \
  --target="tests/PHPStan/PestFeatureTestCase.php" \
  --namespace="Tests\\PHPStan" \
  --class="PestFeatureTestCase"
```

While developing this package locally:

```bash
php tools/generate-pest-proxy.php \
  --source="Tests\\Feature\\TestCase" \
  --target="tests/PHPStan/PestFeatureTestCase.php" \
  --namespace="Tests\\PHPStan" \
  --class="PestFeatureTestCase"
```

Then map the relevant directory to the generated proxy:

```neon
parameters:
    pestClosureThisTypeMap:
        -
            pathContains: '/tests/Feature/'
            class: Tests\PHPStan\PestFeatureTestCase
```

This proxy only affects static analysis. It does not change Pest runtime behavior.

## Limitations

- The extension resolves closure `$this` type only.
- It does not infer dynamic properties automatically; declare those on your test case/traits.
- Mapping is path-substring based, so very broad patterns can match unintentionally.

## Troubleshooting

- No effect in analysis: confirm `extension.neon` is included in your PHPStan config.
- Wrong inferred class: ensure mapping order is specific to broad (first match wins).
- Generator not found: use `vendor/bin/generate-pest-proxy.php` after install or `php tools/generate-pest-proxy.php` in this repository.

## License

MIT
