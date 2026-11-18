---
title: Output Callback
editLink: true
outline: deep
---

# Output Callback

Set `callback_output` in `config/spell-number.php` to customize `toLetters()`, `toMoney()`, and `toOrdinal()`. The callable receives a `DataResponse` after configured replacements, and its return value becomes the method's result.

## 1. Create a callback class

Create `app/Support/SpellNumberOutput.php` in your Laravel application (create the `app/Support` directory if needed). This example changes the words to title case:

```php
<?php

namespace App\Support;

use Illuminate\Support\Str;
use Rmunate\Utilities\Callback\DataResponse;

final class SpellNumberOutput
{
    /** Return the formatted words in title case. */
    public static function format(DataResponse $data): string
    {
        return Str::title($data->getWords());
    }
}
```

## 2. Register it in configuration

If needed, [publish the configuration](../getting-started/publish-vendor.md). In the array returned by `config/spell-number.php`, replace the existing `callback_output` entry:

```php
'callback_output' => [\App\Support\SpellNumberOutput::class, 'format'],
```

## 3. Verify the callback

Run `php artisan config:clear` from the Laravel root if your application has a cached config. Run the following in a controller, command, or test:

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::integer(125)->locale('en')->toLetters();
// "One Hundred Twenty-Five"
```

Set `callback_output` to `null` if you want to restore the default lowercase text. If you return an array or other non-string result, every conversion caller gets that result rather than the original text.

## Using `config:cache` {#using-config-cache}

When deploying with cached configuration, keep the static callable array shown above and run `php artisan config:cache` from the Laravel application root. The array can be saved by Laravel and resolved after the next process loads the cache. Existing closure callbacks work only when configuration is uncached.

## Callback data

| Getter | Value |
| --- | --- |
| `getMethod()` | `toLetters`, `toMoney`, or `toOrdinal`. |
| `getType()` | `integer` or `double`, according to how the input was interpreted. |
| `getValue()` | The original value, before normalization. Also available as `$data->value`. |
| `getWords()` | The converted words, including configured replacements. Also available as `$data->words`. |
| `getLang()` / `getLocale()` | The primary language and the selected locale, such as `es` and `es_MX`. |
| `getCurrency()` / `getFraction()` | The configured currency labels for `toMoney()`, otherwise `null`. |
| `getMode()` | The requested ordinal mode (`default`, `male`, or `female`), otherwise `null`. |

`getValue()` preserves the original type: `float('1.01')` supplies the string `'1.01'`, not a native float. `getMode()` is the requested mode even when ICU uses a compatible fallback rule; `getCurrency()` and `getFraction()` report the configured labels, not their displayed singular forms.
