---
title: Numbers To Letters
editLink: true
outline: deep
---

# Numbers To Letters

## Method Value

### Integers

You can easily convert whole numbers to words by defining the locale to be applied. If you do not define a locale, "en" (English) will be applied by default. Remember that if you export the vendor configuration file, it will not require this definition.

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::value(100)->locale('en')->toLetters();
// "one hundred"

SpellNumber::value(100)->locale('es')->toLetters();
// "cien"

SpellNumber::value(100)->locale('fa')->toLetters();
// "صد"

SpellNumber::value(100)->locale('hi')->toLetters();
// "एक सौ"
```

### Floating Point

If required, you can pass a floating point number as an argument to convert it to words. Only the first two digits after the floating point will be taken.

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::value(123456789.12)->locale('en')->toLetters();
// "one hundred twenty-three million four hundred fifty-six thousand seven hundred eighty-nine and twelve"

SpellNumber::value(123456789.12)->locale('es')->toLetters();
// "ciento veintitrés millones cuatrocientos cincuenta y seis mil setecientos ochenta y nueve con doce"

SpellNumber::value(123456789.12)->locale('hi')->toLetters();
// "बारह करोड़ चौंतीस लाख छप्पन हज़ार सात सौ नवासी और बारह"
```

## Method Integer

You can also rely on the `Integer` method to define that the input is a new integer.
Remember to ensure that the input value is of type `int`.

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::integer(100)->locale('en')->toLetters();
// "one hundred"

SpellNumber::integer(100)->locale('es')->toLetters();
// "cien"
```

## Method Float

Now, if you require it to be translated into letters of more than two decimal places, the solution may be to use the Float method. This method necessarily receives a string value that allows the library to read the complete value sent after the floating point.

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::float('12345.230')->locale('en')->toLetters();
// "twelve thousand three hundred forty-five and two hundred thirty"

SpellNumber::float('12345.230')->locale('es')->toLetters();
// "doce mil trescientos cuarenta y cinco con doscientos treinta"
```

## Especific Locale

If you want to use a specific locale, you should always use the constant `SpellNumber::SPECIFIC_LOCALE`

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::value(100)->locale('es_MX', SpellNumber::SPECIFIC_LOCALE)->toLetters();
// "cien"

SpellNumber::integer(100)->locale('es_MX', SpellNumber::SPECIFIC_LOCALE)->toLetters();
// "cien"

SpellNumber::float('12345.230')->locale('es_MX', SpellNumber::SPECIFIC_LOCALE)->toLetters();
// "doce mil trescientos cuarenta y cinco con doscientos treinta"
```