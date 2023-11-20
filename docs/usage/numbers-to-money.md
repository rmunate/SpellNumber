---
title: Numbers To Money
editLink: true
outline: deep
---

# Numbers To Money

## Method Value

### Integers

It is very easy to use this solution for systems where you require the value more than in letters, with the specified currency structure.
If you require that an integer have this transformation, you can do it in the following way.

```php
SpellNumber::value(100)->locale('en')->currency('Dollars')->toMoney();
// "one hundred dollars"

SpellNumber::value(100)->locale('es')->currency('Pesos')->toMoney();
// "cien pesos"

SpellNumber::value(100)->locale('fa')->currency('تومان')->toMoney();
// "صد تومان"

SpellNumber::value(100)->locale('hi')->currency('रूपये')->toMoney();
// "एक सौ रूपये"
```

### Floating Point

You can also pass a floating point number as an argument to convert it into words in currency format. Only the first two digits after the floating point will be taken.

This method can be useful for invoices, receipts, and similar scenarios. Obtain the supplied value in currency format.

```php
SpellNumber::value(100.12)->locale('en')->currency('Dollars')->fraction('Cents')->toMoney();
// "one hundred dollars and twelve cents"

SpellNumber::value(100.12)->locale('es')->currency('Pesos')->fraction('Centavos')->toMoney();
// "cien pesos con doce centavos"

SpellNumber::value(100.12)->locale('hi')->currency('रूपये')->fraction('पैसे')->toMoney();
// "एक सौ रूपये और बारह पैसे"

SpellNumber::value(100.65)->locale('pl')->currency('złotych')->fraction('groszy')->toMoney();
// "sto złotych i sześćdziesiąt pięć groszy"
```

## Method Integer

You can also rely on the `Integer` method to define that the input is a new integer.
Remember to ensure that the input value is of type `int`.

```php
SpellNumber::integer(100)->locale('es')->currency('Pesos')->toMoney();
// "cien pesos"

SpellNumber::integer(100)->locale('en')->currency('Dollars')->toMoney();
// "one hundred dollars"
```

## Method Float

Now, if you require it to be translated into letters of more than two decimal places, the solution may be to use the Float method. This method necessarily receives a string value that allows the library to read the complete value sent after the floating point.

```php
SpellNumber::float('12345.230')->locale('es')->currency('Pesos')->fraction('Centavos')->toMoney();
// "doce mil trescientos cuarenta y cinco pesos con doscientos treinta centavos"

SpellNumber::float('12345.230')->locale('en')->currency('Dollars')->fraction('Cents')->toMoney();
// "twelve thousand three hundred forty-five dollars and two hundred thirty cents"
```

## Especific Locale

If you want to use a specific locale, you should always use the constant `SpellNumber::SPECIFIC_LOCALE`

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::value(100)->locale('es_MX', SpellNumber::SPECIFIC_LOCALE)->currency('Pesos')->toMoney();
// "cien pesos"

SpellNumber::integer(100)->locale('es_MX', SpellNumber::SPECIFIC_LOCALE)->currency('Pesos')->toMoney();
// "cien pesos"

SpellNumber::float('12345.230')->locale('es_MX', SpellNumber::SPECIFIC_LOCALE)->currency('Pesos')->fraction('Centavos')->toMoney();
// "doce mil trescientos cuarenta y cinco pesos con doscientos treinta centavos"
```