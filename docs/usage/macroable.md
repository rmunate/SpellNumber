---
title: Macros
editLink: true
outline: deep
---

# Macros

Use a macro when several callers need the same application-specific formatting. A macro is a named method you add to SpellNumber with Laravel's `Macroable` trait.

## 1. Register the macro

Open `app/Providers/AppServiceProvider.php` in your Laravel application. Add the import and put the `SpellNumber::macro()` call inside the existing `boot()` method; keep any logic that's already there. If `boot()` is missing, add it as shown:

```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Rmunate\Utilities\SpellNumber;

class AppServiceProvider extends ServiceProvider
{
    /** Register application macros. */
    public function boot(): void
    {
        SpellNumber::macro('toLettersWithSymbol', function (string $symbol): string {
            return $this->toLetters().' - '.$symbol;
        });
    }
}
```

Use a non-static closure: Laravel binds `$this` to the current `SpellNumber` instance. Pick a name that doesn't conflict with a built-in method.

## 2. Call it from a conversion

Import `SpellNumber` where you use the macro:

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::integer(200)->locale('es')->toLettersWithSymbol('$MXN');
// "doscientos - $MXN"
```

This macro expects `toLetters()` to return a string. If you configure a non-string [output callback](./config-custom-callback.md), adjust the macro accordingly. If the method isn't available, check that the application boots `AppServiceProvider` before calling it.

## Existing macros

Inside a bound macro, existing calls to `$this->spell(SpellNumber::TO_LETTERS)`, `$this->spell(SpellNumber::TO_MONEY)`, and `$this->spell(SpellNumber::TO_ORDINAL, SpellNumber::ORDINAL_DEFAULT)` continue to work. Use the public conversion methods directly unless you need to choose a conversion dynamically.
