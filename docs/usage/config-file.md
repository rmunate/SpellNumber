---
title: Configuration
editLink: true
outline: deep
---

# Configuration

Use configuration for settings that should apply across your Laravel application. Use fluent setters to change a specific conversion without changing those defaults.

## Set up the file

[Publish the configuration](../getting-started/publish-vendor.md), then open `config/spell-number.php` in your Laravel application. The package uses the following defaults even if you skip publishing:

| Key | Default | Description |
| --- | --- | --- |
| `default.locale` | `null` | Use the primary language of `app.locale` if it is a preset; otherwise use `en`. Set a locale to override this behavior. |
| `default.specific_locale` | `false` | Allow regional and additional ICU locales. |
| `default.currency` | `dollars` | Name of the whole currency unit. |
| `default.fraction` | `cents` | Name of the fractional currency unit. |
| `default.ordinal_output` | `default` | Ordinal rule: `default`, `male`, or `female`. |
| `replacements` | `[]` | Substrings to replace, grouped by primary language. |
| `callback_output` | `null` | Optional [callable](./config-custom-callback.md) that receives the result and context. |

## Example: use Mexican Spanish and pesos

This is a complete example for `config/spell-number.php`. Merge it with existing settings rather than overwriting them unintentionally:

```php
<?php

return [
    'default' => [
        'locale' => 'es_MX',
        'specific_locale' => true,
        'currency' => 'pesos',
        'fraction' => 'centavos',
        'ordinal_output' => 'default',
    ],
    'replacements' => [
        'es' => [
            'pesos' => 'pesos mexicanos',
        ],
    ],
    'callback_output' => null,
];
```

After you clear or rebuild the configuration cache, the following converts an amount using those defaults:

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::float('100.12')->toMoney();
// "cien pesos mexicanos con doce centavos"

SpellNumber::float('100.12')->locale('en')->currency('dollars')->fraction('cents')->toMoney();
// "one hundred dollars and twelve cents"
```

The second call overrides the default language and both labels for that instance only.

## How settings are applied

1. The initial locale comes from `default.locale`, or from Laravel if the setting is `null`. A non-null legacy `default.lang` takes precedence over `default.locale`; remove or rename it if your new value appears to be ignored.
2. Explicit calls to `locale()`, `currency()`, and `fraction()` override the initial settings on that instance. For ordinals, a mode argument to `toOrdinal()` overrides `default.ordinal_output`.
3. The converter builds the text, applies [replacements](#replacements) for the final locale, and then passes the replaced text to the [output callback](./config-custom-callback.md) if one is configured.

## Replacements

These are substring replacements, not whole-word rules. Use the primary language code (`es`, not `es_MX`). The text, search key, and replacement are lowercased; replacements are applied in the order you list them. Prefer narrow phrases if a short substring might match unrelated words.

## Apply changes

Run `php artisan config:clear` from the Laravel application root during local development if config was cached. On a deployment that uses cached configuration, run `php artisan config:cache` after updating the file.

If configuration caching fails, check [callback serialization](./config-custom-callback.md#using-config-cache).
