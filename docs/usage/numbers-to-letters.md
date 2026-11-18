---
title: Numbers to Letters
editLink: true
outline: deep
---

# Numbers to Letters

Use `toLetters()` when you want cardinal words without currency names. Import `SpellNumber` wherever you run the conversion (a controller, command, or test).

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::integer(100)->locale('en')->toLetters();
// "one hundred"

SpellNumber::value(100)->locale('es')->toLetters();
// "cien"

SpellNumber::value(12.5)->locale('en')->toLetters();
// "twelve and fifty"

SpellNumber::float('12345.230')->locale('es')->toLetters();
// "doce mil trescientos cuarenta y cinco con doscientos treinta"

SpellNumber::value('-0.01')->locale('en')->toLetters();
// "minus zero and one"
```

## Input types

| Factory | Accepted input |
| --- | --- |
| `value()` | A PHP integer, a finite PHP float written as a plain decimal by PHP, or a decimal string. Use it when the data may arrive in more than one of those types. |
| `integer()` | A native PHP `int`. Use it when your application already has a whole number, not a string from a form. |
| `float()` | A decimal string, **not** a PHP `float`. Use it when the original digits matter. |

Use ASCII digits (`0`–`9`), an optional leading `+` or `-`, and a dot for the decimal separator. Leading zeros and surrounding ASCII whitespace are accepted. You can omit the whole digits (`'.5'`) or the fractional digits (`'12.'`), but not both. Grouping separators, a decimal comma, exponent strings like `'1e3'`, `NaN`, and infinity are not accepted. Normalize localized form input before conversion.

### How the fraction is read

The fractional component is spelled as a number, not digit by digit. A single digit is right-padded; longer strings are kept without rounding or truncation:

| Input in `en` | Output |
| --- | --- |
| `value('.5')` | `zero and fifty` |
| `value(' +0008.03 ')` | `eight and three` |
| `float('2.0')` | `two and zero` |
| `float('2.230')` | `two and two hundred thirty` |
| `value('12.')` | `twelve` |

Use an explicit string to retain trailing zeros: a native float does not remember how many decimal places you wrote. A float that PHP serializes in scientific notation is rejected; pass an equivalent plain decimal string if you need that input.

### Range and errors

The whole and fractional components must each fit in PHP's native integer range. ICU can impose a smaller limit depending on the locale and rule; SpellNumber rejects results that ICU can only render as digits. Catch [`SpellNumberExceptions`](../reference/api.md#catch-conversion-errors) if the input comes from outside your application.

If you omit `locale()`, SpellNumber uses the [configured default](./config-file.md). See [supported languages](./languages-available.md) to use regional locales.
