# Locally maintained dependencies

These two packages are abandoned upstream (jaxl 2016, php-pushover 2019) and
contain code that is deprecated in PHP 8.5 and will break in PHP 9. They are
kept here as patched copies and installed by Composer through `path`
repositories (see `repositories` in the root `composer.json`), so
`composer install` keeps working and the patches are not overwritten.

Every change is marked with a `PSM patch` comment, except the one-word cast fix.

## jaxl/jaxl 3.1.0 -> 3.1.0.1 (BSD-3-Clause, see jaxl/LICENSE)

- `src/JAXL/core/jaxl_util.php`: `get_nonce()` used `mt_srand((double) microtime()...)`
  (non-canonical cast deprecated in 8.5, implicit float->int deprecated in 8.1) and
  `mt_rand()` for an authentication nonce. Now `random_bytes(32)`.
- `src/JAXL/core/jaxl_xml_stream.php`: removed `xml_parser_free()` (no-op since 8.0,
  deprecated in 8.5); `xml_parse()` no longer receives `null` (deprecated in 8.1).
- `src/JAXL/core/jaxl_pipe.php`: declared `$ev` and `$read_cb` (dynamic properties
  are deprecated since 8.2).
- Removed tests/docs/examples and require-dev.

## php-pushover/php-pushover 1.0.1 -> 1.0.1.1 (MIT, see php-pushover/LICENSE)

- `Pushover.php`: `(boolean)` cast -> `(bool)` (non-canonical casts deprecated in 8.5).
- Removed `test.php`.
