---
title: Supported Languages
editLink: true
outline: deep
---

# Supported Languages

## Locale presets

Use a preset directly with `->locale('es')`, without any extra flag. Presets define the connector used between whole and fractional parts. ICU supplies the number words.

| Code | Language | Fraction connector |
| --- | --- | --- |
| `de` | German | `und` |
| `en` | English | `and` |
| `es` | Spanish | `con` |
| `fa` | Farsi | `ممیز` |
| `fr` | French | `et` |
| `hi` | Hindi | `और` |
| `it` | Italian | `con` |
| `pl` | Polish | `i` |
| `pt` | Portuguese | `com` |
| `ro` | Romanian | `cu` |
| `vi` | Vietnamese | `và` |

```php
use Rmunate\Utilities\SpellNumber;

$codes = SpellNumber::getAvailableLocales();     // ['de', 'en', 'es', ...]
$names = SpellNumber::getAvailableLanguages();   // ['de' => 'German', ...]
```

## Regional and additional locales

For a regional variant such as Swiss French, use an installed ICU locale with a hyphen or underscore. Pass `SpellNumber::SPECIFIC_LOCALE` as the second argument, or opt in for all instances with `default.specific_locale` in the [configuration](./config-file.md):

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::integer(70)->locale('fr-CH', SpellNumber::SPECIFIC_LOCALE)->toLetters();
// "septante"

$words = SpellNumber::float('2.5')->locale('nl', SpellNumber::SPECIFIC_LOCALE)->toLetters();
// $words is "twee, vijftig"

$icuLocales = SpellNumber::getAllLocales();
```

The ICU list includes resource locales that may not have their own spellout rules. SpellNumber allows ICU to use rules from the same language, but raises `SpellNumberExceptions` if ICU falls back to another language. Languages without a preset use the ICU decimal separator instead of a word between the parts.

When you omit `locale()`, the configured locale takes precedence. Without one, the package tries the primary language of Laravel's `app.locale`: `es_CO` becomes `es`; an application locale without a preset falls back to `en`. For regional wording, set the full locale explicitly.

For important outputs, test the exact input and locale in production's PHP/ICU version. A working cardinal rule doesn't imply a working [ordinal rule](./numbers-to-ordinal.md#rule-selection).
