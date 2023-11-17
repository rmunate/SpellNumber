---
title: Macroable
editLink: true
outline: deep
---

# Macroable

You likely have excellent ideas for methods that could greatly benefit from the capabilities of **SpellNumber**. We encourage you to create them yourself.

## Creating a Macro

To develop a custom method, you can establish a new provider and register it within your application, following the guidelines in the [Laravel Documentation](https://laravel.com/docs/10.x/providers). This approach can lead to a more organized and clear code structure. For this guide's purposes, we'll utilize the `AppServiceProvider`, which is readily available and located at `app/Providers/AppServiceProvider.php`.

Within the `register()` method of the Provider, you can craft your custom method. For practical demonstration, let's create the `toLettersWithSymbol` method. This method will transform the supplied value into words, followed by the currency symbol and its abbreviation. The output will be **'Two hundred - $MXN'**.

```php
namespace App\Providers;

use Rmunate\Utilities\SpellNumber;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        SpellNumber::macro('toLettersWithSymbol', function (string $symbol) {
        
            $value = $this->spell(SpellNumber::TO_LETTERS);

            return "$value - $symbol";
        });
    }
}
```

## The Spell Method

If you observe, the "spell" method is used within the constructed macro. This method is exclusively available in this context and cannot be utilized elsewhere. It facilitates the effortless conversion of the provided value into words, as needed.

To Letters:
```php
$this->spell(SpellNumber::TO_LETTERS)
```

To Money Format:
```php
$this->spell(SpellNumber::TO_MONEY)
```

To Ordinal Text:
```php
$this->spell(SpellNumber::TO_ORDINAL, SpellNumber::ORDINAL_DEFAULT)
```

## How to Use My Macro

Now that you have created your macro within the service provider, simply call it like an original method of the SpellNumber class.

```php
SpellNumber::value(200)->locale('es_MX', SpellNumber::SPECIFIC_LOCALE)->toLettersWithSymbol('$MXN')
// "Doscientos - $MXN"
```

You now possess the ability to create unique solutions within your applications.