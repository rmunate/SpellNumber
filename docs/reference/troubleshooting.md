---
title: Troubleshooting
description: Diagnose Laravel installation, PHP Intl, number validation, locale rules, and cached configuration.
editLink: true
outline: deep
---

# Troubleshooting

Begin with the exact input and its type, the locale, the method you're calling, and the error message. For example, `2`, `2.0`, `'2'`, and `'2.0'` are not interchangeable for `toOrdinal()`.

## Check the PHP runtime

If Composer reports a missing `ext-intl` or the package says that Intl is required, check the PHP process that fails:

```shell
php -v
php --ini
php --ri intl
php --ri mbstring
```

Run these commands inside the same PHP container if you use containers. They describe the **CLI** binary, not a separate Apache or PHP-FPM binary. If Artisan passes but HTTP requests fail, compare the web runtime with the CLI runtime and enable the extensions in both. Use the [installation instructions](../getting-started/installation.md#enable-missing-extensions) rather than bypassing Composer's platform checks.

## Composer does not install the package

From the application's root, check what is installed and what blocks the target version:

```shell
composer show rmunate/spell-number
composer why-not rmunate/spell-number 5.0.0
```

If the first command says the package is missing, verify that it is required in your application's `composer.json`. If the second shows a PHP or Illuminate constraint, use the [compatibility table](../getting-started/installation.md#runtime-requirements) to identify what must change. If Composer cannot find the requested release at all, check the published versions on [Packagist](https://packagist.org/packages/rmunate/spell-number).

## Input is rejected or the result is not what you expected

| Symptom | Check or fix |
| --- | --- |
| `integer()` requires a PHP int | Use `integer(2)` for a native integer, or `value('2')` for an integer string. |
| `float()` requires a decimal string | Use `float('12.50')` for exact digits or `value(12.5)` for a native float. |
| The number needs a dot and no grouping separators | Send a plain string like `'1234.50'`. Don't send `'1,234.50'`, `'1234,50'`, or `'1e3'`. Normalize localized input before converting it. |
| A component falls outside the PHP integer range | Both the whole and fractional components are checked separately. Do not cast an overflowing string to `int` to get around the check; reduce the input or use a formatter that handles the larger range. |
| ICU could not spell out a value | Some rules return digits rather than words for large or unsupported values. Use a smaller input or a locale with a suitable ICU rule. Check the [input limits](../usage/numbers-to-letters.md#input-types). |
| `.5` is spelled as fifty, or `.230` as two hundred thirty | A single fractional digit is right-padded; longer strings are not rounded. Prepare the required scale in your application before calling [`toMoney()`](../usage/numbers-to-money.md#decimal-precision). |

## Locale or ordinal rule is not available

- For a preset such as `es`, pass `->locale('es')`. For a supported regional locale such as `es_MX`, pass `->locale('es_MX', SpellNumber::SPECIFIC_LOCALE)` or opt in through config.
- Being listed by `getAllLocales()` does not guarantee that ICU has spellout or ordinal rules for that locale. Try the base language, or choose another locale and confirm the wording expected by your users.
- `toOrdinal()` requires an integer input. Use `integer(2)` or `value('2')`, not `float('2')`, `value(2.0)`, or `value('2.0')`. If a gendered rule is unavailable, see [ordinal rule selection](../usage/numbers-to-ordinal.md#rule-selection).
- If results differ between environments for the same locale and input, compare the ICU versions reported by `php --ri intl`. Test important wording in the PHP runtime you deploy.

## Settings are ignored or `config:cache` fails

1. Edit `config/spell-number.php` in your application, not the file under `vendor/`. If the file doesn't exist, [publish it](../getting-started/publish-vendor.md).
2. Run `php artisan config:clear` locally so Laravel reads the updated file. Check for an older `default.lang` entry, which takes precedence over `default.locale`.
3. If `php artisan config:cache` reports non-serializable config, set `callback_output` to `null` or to a [static callable](../usage/config-custom-callback.md#using-config-cache), not a closure or an object.
4. If `vendor:publish` doesn't list the provider, confirm [package discovery or manual registration](../getting-started/installation.md#provider-registration).

Still blocked? [Report a bug](../contribute/report-bugs.md) with a minimal snippet and the PHP, Laravel, ICU, and SpellNumber versions.
