---
title: Introduction
editLink: true
outline: deep
---

# Introduction

SpellNumber uses PHP's Intl extension and ICU language data to write a numeric value in words. Use it when an application needs wording, not a number formatted with separators or a currency symbol.

## What can I convert?

| I need to write… | Use | Example |
| --- | --- | --- |
| A count or decimal | [`toLetters()`](../usage/numbers-to-letters.md) | `125` → `one hundred twenty-five` |
| A payable amount with named units | [`toMoney()`](../usage/numbers-to-money.md) | `'1.01'` → `one dollar and one cent` |
| A position or rank | [`toOrdinal()`](../usage/numbers-to-ordinal.md) | `2` → `second` |

Each conversion starts by creating an instance with `value()`, `integer()`, or `float()`. You can then select a locale and call a conversion method. The method returns lowercase text by default.

::: tip Use a string for an exact decimal
Pass `'1.01'`, not a value that has already been rounded to a PHP float, when the exact fractional digits matter. See the [complete input rules](../usage/numbers-to-letters.md#input-types).
:::

## Where do I start?

1. Follow [Installation](./installation.md) to check your Laravel and PHP versions, enable Intl, and install the package.
2. Follow the [Quickstart](./quickstart.md) for a complete Laravel route and the response it should return.
3. Use the [API reference](../reference/api.md) to look up a method or [Configuration](../usage/config-file.md) to set application-wide defaults.

New in 5.0.0: Laravel 13 support. If your application uses 4.x, first read the [upgrade notes](./changelog.md#500).
