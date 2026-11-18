---
title: Release Notes
editLink: true
outline: deep
---

# Release Notes

## 5.0.0 {#500}

- Adds Laravel 13 support without removing the Laravel 8–12 Composer constraints.
- Validates numeric inputs and range before formatting, preserves the sign of negative fractions below one, and keeps decimal-string digits without coercing through a float.
- Corrects monetary grammar for known labels and large-scale words. Ordinals use an available ICU spellout rule or raise an exception instead of silently returning a cardinal.
- Loads package defaults without publishing the configuration and ships a default compatible with Laravel's `config:cache`.
- Checks conversions and Laravel configuration on CI, and deploys the documentation to GitHub Pages only after the checks pass.

### Upgrading from 4.x

From the application's Laravel root, update the package with:

```shell
composer require "rmunate/spell-number:^5.0"
composer show rmunate/spell-number
```

After Composer reports a 5.x release, make these changes in your application:

1. Replace `SpellNumber::getLocales()` and `SpellNumber::getLanguages()` with `getAvailableLocales()` and `getAvailableLanguages()`. Internal base classes and validation traits are no longer part of the package.
2. In an already published config, replace the default closure under `callback_output` with `null`, or use a [static callable](../usage/config-custom-callback.md) if you cache config. Rename `default.lang` to `default.locale`; the legacy key is still accepted and takes precedence when present.
3. If you want to inherit the application's preset language, set `default.locale` to `null`. Use `default.specific_locale` for an explicit regional or additional ICU locale.
4. Review numeric inputs and persisted strings. Invalid numbers, unsupported locales or ordinal rules, and outputs that ICU can only render as digits raise `SpellNumberExceptions`. The callback still receives the original input; `value('2')` now classifies that input as an integer.
5. Text remains lowercase unless you customize it. If you persist money or ordinal wording, recheck representative outputs, especially singular labels, large amounts, and gendered ordinals.

::: tip Verify before you deploy
Run the [Quickstart](./quickstart.md) or your application's conversion tests. If your deployment uses cached config, run `php artisan config:cache` with the updated configuration before switching traffic.
:::

## 4.3.0

- Added Laravel 12 support.

## 4.2.2 (2023-11-28)

- Removed soft hyphens and zero-width spaces from ICU conversion output.

## 4.2.0 (2023-11-20)

- Added Vietnamese language support.
- Switched default output casing from title case to lowercase.
