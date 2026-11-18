---
title: Numbers to Money
editLink: true
outline: deep
---

# Numbers to Money

Use `currency()` and `fraction()` to supply the labels for the whole and fractional units:

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::integer(100)->locale('es')->currency('pesos')->toMoney();
// "cien pesos"

SpellNumber::float('100.12')->locale('es')->currency('pesos')->fraction('centavos')->toMoney();
// "cien pesos con doce centavos"

SpellNumber::float('1.01')->locale('en')->toMoney();
// "one dollar and one cent"

SpellNumber::value('100.65')->locale('pl')->currency('złotych')->fraction('groszy')->toMoney();
// "sto złotych i sześćdziesiąt pięć groszy"
```

## Currency labels and grammar

The default labels are `dollars` and `cents`, even if you select a different language. Set both labels if you want different units; `locale('es')` changes the number wording, not the currency automatically.

SpellNumber knows the English singulars `dollar` and `cent`. In Spanish it handles common labels including `balboas`, `bolívares`, `centavos`, `céntimos`, `colones`, `córdobas`, `dólares`, `euros`, `lempiras`, `pesos`, `quetzales`, and `soles`. For example:

| Example in `es` with `pesos` / `centavos` | Result |
| --- | --- |
| `'1.01'` | `un peso con un centavo` |
| `31` | `treinta y un pesos` |
| `1000000` | `un millón de pesos` |
| `1000021` | `un millón veintiún pesos` |

For other labels, supply the singular or plural form appropriate to each part of the amount. Custom labels are lowercased along with the rest of the output. Use [an output callback](./config-custom-callback.md) if you need to restore capitalization or apply your own wording.

## Decimal precision

SpellNumber spells the amount you pass. It does not convert currencies, infer minor units from ISO codes, or round amounts. Normalize financial amounts in your application before calling `toMoney()`; use a string to avoid float rounding.

A single fractional digit represents tenths (`'12.5'` is spelled as twelve whole units and fifty fractional units). If you explicitly supply more than two digits, they are kept (`'12.230'` is spelled as twelve whole units and two hundred thirty fractional units). See [Numbers to Letters](./numbers-to-letters.md#input-types) for the full input rules.

| Input with default English units | Result |
| --- | --- |
| `integer(12)` | `twelve dollars` |
| `float('12.00')` | `twelve dollars and zero cents` |
| `float('12.05')` | `twelve dollars and five cents` |
| `float('-0.05')` | `minus zero dollars and five cents` |

::: warning Normalize first for invoices
For a currency that uses hundredths, pass an exact two-place string such as `'12.05'` from your decimal calculation or validated source. Keep the original amount for storage and arithmetic; SpellNumber only produces wording.
:::

## Show the result in Blade

In the controller action that renders your invoice, prepare the words and pass them to the view. This example uses a fixed decimal string; replace it with the already-normalized amount from your application.

```php
use Rmunate\Utilities\SpellNumber;

// Inside the controller action:
$amountInWords = SpellNumber::float('100.12')
    ->locale('es')
    ->currency('pesos')
    ->fraction('centavos')
    ->toMoney();

return view('invoice', ['amountInWords' => $amountInWords]);
```

In `resources/views/invoice.blade.php`, use Blade's escaped interpolation:

```blade
<p>Amount in words: {{ $amountInWords }}</p>
```

With the default output settings, the line reads `Amount in words: cien pesos con doce centavos`. If you use an [output callback](./config-custom-callback.md), keep its return value a string for this view.
