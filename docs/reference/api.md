---
title: API reference
description: SpellNumber methods, accepted input types, locale selection, return values, and errors.
editLink: true
outline: deep
---

# API reference

Import `Rmunate\Utilities\SpellNumber` to use the conversion API. A factory creates an instance, setters configure that instance, and a conversion method returns the result.

```php
use Rmunate\Utilities\SpellNumber;

$number = SpellNumber::integer(125);
$number->locale('en');
$words = $number->toLetters();
// $words is "one hundred twenty-five"
```

## Create an instance

| Static method | Value to pass | Returns |
| --- | --- | --- |
| `value($value)` | A PHP `int`, a finite PHP `float` that can be represented as a plain decimal, or a decimal string. | A new `SpellNumber` |
| `integer($value)` | A PHP `int`. A quoted integer such as `'125'` is not accepted by this method. | A new `SpellNumber` |
| `float($value)` | A decimal string. Despite its name, this method does not accept a native PHP `float`. | A new `SpellNumber` |

Prefer the factories to calling the constructor directly. For plain strings with no decimal point, `value()` classifies the input as an integer. It classifies native floats and strings containing a decimal point as `double`. `float()` always selects `double`. See [valid and invalid inputs](../usage/numbers-to-letters.md#input-types).

## Configure an instance

| Method | Argument | Effect |
| --- | --- | --- |
| `locale(string $locale, ?bool $specific_locale = null)` | A [language or locale code](../usage/languages-available.md). Pass `SpellNumber::SPECIFIC_LOCALE` as the second argument to explicitly allow an installed regional or additional ICU locale. | Sets the language and regional spelling rules. |
| `currency(string $currency)` | The whole-unit label, such as `'pesos'`. | Used only by `toMoney()`. |
| `fraction(string $fraction)` | The fractional-unit label, such as `'centavos'`. | Used only by `toMoney()` and only when the input contains fractional digits to spell. |

Setters modify and return the **same instance** so you can chain them. Create a new instance for a different number. A `null` second argument to `locale()` follows `default.specific_locale`; an explicit `false` restricts the call to presets even when the global setting is `true`.

## Convert

| Method | Result with default output settings | Important condition |
| --- | --- | --- |
| [`toLetters()`](../usage/numbers-to-letters.md) | Cardinal number in lowercase words. | Both number components must fit a PHP integer and be spellable by ICU. |
| [`toMoney()`](../usage/numbers-to-money.md) | Lowercase words with currency and fractional labels. | Does not round, convert currencies, or look up ISO minor units. |
| [`toOrdinal(?string $attr = null)`](../usage/numbers-to-ordinal.md) | Ordinal in lowercase words. | Input must be classified as an integer and ICU must have a compatible rule. |

The methods return `string` by default. If you configure a [callback](../usage/config-custom-callback.md), they return **whatever the callback returns**. Keep the callback's return type consistent with your callers' expectations.

### Ordinal constants

| Constant | Equivalent mode |
| --- | --- |
| `SpellNumber::ORDINAL_DEFAULT` | `'default'` |
| `SpellNumber::ORDINAL_MALE` | `'male'` |
| `SpellNumber::ORDINAL_FEMALE` | `'female'` |

Without an argument, `toOrdinal()` uses `default.ordinal_output`. See [rule selection](../usage/numbers-to-ordinal.md#rule-selection) for fallback behavior.

## Discover locales

| Static method | Returns |
| --- | --- |
| `getAvailableLocales()` | `list<string>`: preset codes such as `en`, `es`, and `pl`. |
| `getAvailableLanguages()` | `array<string, string>`: preset codes mapped to their English names. |
| `getAllLocales()` | `list<string>`: locales advertised by the installed ICU resource bundle, including locales without spellout rules. |

For named application helpers, see [Macros](../usage/macroable.md). Output callbacks receive a [`DataResponse`](../usage/config-custom-callback.md#callback-data) with both the original value and the formatted result.

## Catch conversion errors

Invalid input, an unsupported locale or ordinal rule, and spellout failures raise `Rmunate\Utilities\Exceptions\SpellNumberExceptions`. The error may occur when creating an instance, setting its locale, or converting it. Wrap the entire chain when processing user input.

For a local example, add this route to `routes/web.php`. Add the imports at the top if they aren't already there:

```php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Rmunate\Utilities\Exceptions\SpellNumberExceptions;
use Rmunate\Utilities\SpellNumber;

Route::get('/spell-number-preview', function (Request $request) {
    try {
        $words = SpellNumber::value($request->query('number'))->locale('en')->toLetters();
    } catch (SpellNumberExceptions $exception) {
        return response()->json(['message' => 'Enter a spellable decimal number.'], 422);
    }

    return response()->json(['words' => $words]);
});
```

Request `/spell-number-preview?number=125` to get `{"words":"one hundred twenty-five"}`. Use `?number=1e3` to verify the `422` response for an invalid decimal string. This is a local example with known working configuration. In production, validate client input at the application boundary and treat server configuration or runtime failures separately. See [Troubleshooting](./troubleshooting.md).
