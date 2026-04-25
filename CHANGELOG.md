# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.1] - 2026-04-25

### Fixed
- Correct the Composer PHP requirement to `^8.3`.
- Run CI on PHP 8.3 and 8.4 only.

### Added
- Add missing public-package hygiene files: `.gitattributes`, `SECURITY.md`, `CODE_OF_CONDUCT.md`, and `GEMINI.md`.

## [1.0.0] - 2026-04-25

### Changed
- Removed default Pest test case mappings from `extension.neon`.
- Projects must now configure `pestClosureThisTypeMap` explicitly.

### Added
- Initial PHPStan extensions for Pest closure `$this` inference via path mappings.
- Proxy generator tool for PHPStan-only test case wrappers.
- Base project documentation and release workflow files.

## [0.1.0] - 2026-02-13

### Added
- First public release of `odinns/phpstan-pest-this`.
