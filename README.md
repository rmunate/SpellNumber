# Convert Numbers to Words in Laravel

Easily convert numbers to words in Laravel using this library, which leverages the native `PHP INTL` extension to perform conversion effortlessly. With this library, you can convert numbers to words in various languages and also obtain the value in currency format according to the selected language. Supported languages include English, Spanish, Portuguese, French, Italian, Romanian, and with the contribution of [Siros Fakhri](https://github.com/sirosfakhri), Persian (Farsi) support has been added.

⚙️ This library is compatible with Laravel versions 8.0 and higher ⚙️

![Laravel 8.0+](https://img.shields.io/badge/Laravel-8.0%2B-orange.svg)
![Laravel 9.0+](https://img.shields.io/badge/Laravel-9.0%2B-orange.svg)
![Laravel 10.0+](https://img.shields.io/badge/Laravel-10.0%2B-orange.svg)

![SpellNumbers](https://github.com/rmunate/SpellNumber/assets/91748598/f2aea68b-fc9f-46be-ae54-a4955f0ce7a2)

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Creator](#creator)
- [Contributors](#contributors)
- [License](#license)

## Installation

To install the dependency via Composer, execute the following command:

```shell
composer require rmunate/spell-number
```

It's important to ensure that the `intl` extension is enabled and loaded in the environment.

## Usage

After installing the dependency in your project, you can start using it with the following examples:

#### Knowing Supported Regional Configurations

To obtain the current list of languages with support, execute the following command:

```php
SpellNumber::getAllLocales();
// array:7 [▼
//     0 => "en" (English)
//     1 => "es" (Spanish)
//     2 => "pt" (Portuguese)
//     3 => "fr" (French)
//     4 => "it" (Italian)
//     5 => "ro" (Romanian)
//     6 => "fa" (Farsi)
// ]
```

#### Convert Integers to Words

You can easily convert numbers to words by defining the regional configuration to apply. If you don't define a regional configuration, "en" (English) will be applied by default.

```php
SpellNumber::value(100)->locale('es')->toLetters();
// "Cien"

SpellNumber::value(100)->locale('fa')->toLetters();
// "صد"

SpellNumber::value(100)->locale('en')->toLetters();
// "One Hundred"
```

#### Convert Floating-Point Numbers

If needed, you can pass a floating-point number as an argument to convert it to words.

```php
SpellNumber::value(123456789.12)->locale('es')->toLetters();
// "Ciento Veintitrés Millones Cuatrocientos Cincuenta Y Seis Mil Setecientos Ochenta Y Nueve Con Doce"
```

#### Convert to Currency Format

This method can be useful for invoices, receipts, and similar scenarios. Obtain the supplied value in currency format.

```php
SpellNumber::value(100)->locale('es')->currency('pesos')->toMoney();
// "Cien Pesos"

SpellNumber::value(100.12)->locale('es')->currency('Pesos')->fraction('centavos')->toMoney();
// "Cien Pesos Con Doce Centavos"

SpellNumber::value(100)->locale('fa')->currency('تومان')->toMoney();
// "صد تومان"
```

#### Other Initializer Methods

To support version 1.X, the following initializer methods are maintained.

```php
// Integer, this method strictly requires an integer value to be sent as an argument.
SpellNumber::integer(100)->locale('es')->toLetters();

// Floating-point numbers, this method strictly requires a string value as an argument.
SpellNumber::float('12345.23')->locale('es')->toLetters();
```

## Creator

- 🇨🇴 Raúl Mauricio Uñate Castro
- Email: raulmauriciounate@gmail.com

## Contributors
[Siros Fakhri](https://github.com/sirosfakhri) (Farsi Language)

## License

This project is licensed under the [MIT License](https://choosealicense.com/licenses/mit/).