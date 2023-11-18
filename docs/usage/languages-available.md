---
title: Supported Languages
editLink: true
outline: deep
---

# Supported Languages

We currently have 11 preset languages to easily work with this package. _Although you can use other configurations with arbitrary outputs_, we list the pre-configured languages below:

- German.
- English.
- Spanish.
- Farsi.
- French.
- Hindi.
- Italian.
- Polish.
- Portuguese.
- Romanian.
- Vietnamese.

If you want to get the supported languages directly from the package, you have two ways to do it.

## Available Locales
Execute the method `getAvailableLocales`, as output it will give you an array with the available values.

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::getAvailableLocales();

// array:10 [▼
//   0 => "de"
//   1 => "en"
//   2 => "es"
//   3 => "fa"
//   4 => "fr"
//   5 => "hi"
//   6 => "it"
//   7 => "pl"
//   8 => "pt"
//   9 => "ro"
//   10 => "vi"
// ]
```

## Available Languages

Execute the method `getAvailableLanguages`, as output it will give you an associative array with the values of available languages.

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::getAvailableLanguages();

// array:10 [▼ 
//   "de" => "German"
//   "en" => "English"
//   "es" => "Spanish"
//   "fa" => "Farsi"
//   "fr" => "French"
//   "hi" => "Hindi"
//   "it" => "Italian"
//   "pl" => "Polish"
//   "pt" => "Portuguese"
//   "ro" => "Romanian"
//   "vi" => "Vietnamese"
// ]
```

## Other Locales

If you would like to try a language other than the 10 previously mentioned, you can consult the different values that you can supply to the package to try to generate the output translated to said area and language.

In order to use any of these options, you must use the constant `SpellNumber::SPECIFIC_LOCALE` in the `locale` method, example `->locale('es_MX', SpellNumber::SPECIFIC_LOCALE)`.


```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::getAllLocales();

// array:805 [▼ 
//     0 => "af"
//     1 => "af_NA"
//     2 => "af_ZA"
//     3 => "agq"
//     4 => "agq_CM"
//     5 => "ak"
//     6 => "ak_GH"
//     7 => "am"
//     8 => "am_ET"
//     9 => "ar"
//     10 => "ar_001"
//     ...
// ]
```