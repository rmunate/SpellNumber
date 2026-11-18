---
title: Quickstart
description: Copy a Laravel route, run it locally, and verify three SpellNumber conversions.
editLink: true
outline: deep
---

# Quickstart

Create one Laravel route that returns a number, a money amount, and an ordinal in words. Start with a working Laravel app and [SpellNumber installed](./installation.md). No published package configuration is needed.

## 1. Add the route

Open `routes/web.php`. Add the `use` statements at the top if they aren't already there, then add the route below any existing routes. Do not insert a second `<?php` tag.

```php
use Illuminate\Support\Facades\Route;
use Rmunate\Utilities\SpellNumber;

Route::get('/spell-number-demo', function () {
    return response()->json([
        'letters' => SpellNumber::integer(125)->locale('en')->toLetters(),
        'money' => SpellNumber::float('100.12')
            ->locale('es')
            ->currency('pesos')
            ->fraction('centavos')
            ->toMoney(),
        'ordinal' => SpellNumber::integer(2)
            ->locale('es')
            ->toOrdinal(SpellNumber::ORDINAL_FEMALE),
    ]);
});
```

- `integer(125)` and `integer(2)` use PHP integers.
- `float('100.12')` takes a **string**, so the fractional digits stay exact.
- `locale()` makes the examples independent of the application's language. The ordinal requests the feminine Spanish form.

## 2. Run the application

If your app is already running locally, use its existing URL. Otherwise, from the Laravel application root run:

```shell
php artisan serve --host=127.0.0.1 --port=8000
```

Open **http://127.0.0.1:8000/spell-number-demo** in your browser. The route itself does not query a database. On a disposable demo app with database sessions but no configured database, set `SESSION_DRIVER=array` in `.env`, run `php artisan config:clear`, then restart the local server. Don't change the session driver in a deployed application just to run this demo.

## 3. Verify the response

With the default SpellNumber output settings, the JSON values should be:

```json
{
  "letters": "one hundred twenty-five",
  "money": "cien pesos con doce centavos",
  "ordinal": "segunda"
}
```

If the route returns `404`, run `php artisan route:list --path=spell-number-demo` from the Laravel root. If the route is missing and routes were cached, clear the local route cache with `php artisan route:clear` and check again. If the conversion itself fails, use the [troubleshooting guide](../reference/troubleshooting.md). Remove the demo route when you're done.

## Next steps

- [Choose the correct input type](../usage/numbers-to-letters.md#input-types) for values from a form or database.
- [Prepare money amounts](../usage/numbers-to-money.md) before passing them to SpellNumber.
- [Set global defaults](../usage/config-file.md) so you don't repeat the locale or currency on every call.
