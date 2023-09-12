# Convert Numbers to Words in Laravel

Easily convert numbers to words in Laravel using this library, which leverages the native `PHP INTL` extension to perform conversion effortlessly. With this library, you can convert numbers to words in various languages and also obtain the value in currency format according to the selected language. Supported languages include English, Spanish, Portuguese, French, Italian, Romanian, Hindi, Polish and Persian (Farsi).

⚙️ This library is compatible with PHP +8.0 and Laravel versions 8.0 and higher ⚙️

![Laravel 8.0+](https://img.shields.io/badge/Laravel-8.0%2B-orange.svg)
![Laravel 9.0+](https://img.shields.io/badge/Laravel-9.0%2B-orange.svg)
![Laravel 10.0+](https://img.shields.io/badge/Laravel-10.0%2B-orange.svg)

![logo-spell-number](https://github.com/alejandrodiazpinilla/SpellNumber/assets/51100789/e51cf045-26d0-44e0-a873-3034deaea046)

📖 [**DOCUMENTACIÓN EN ESPAÑOL**](README_SPANISH.md) 📖

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
// array [
//    'de', // German
//    'en', // English
//    'es', // Spanish
//    'pt', // Portuguese
//    'fr', // French
//    'it', // Italian
//    'ro', // Romanian
//    'fa', // Farsi
//    'hi', // Hindi
//    'pl', // Polish
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

SpellNumber::value(100)->locale('hi')->toLetters();
// "एक सौ"
```

#### Convert Floating-Point Numbers

If needed, you can pass a floating-point number as an argument to convert it to words.

```php
SpellNumber::value(123456789.12)->locale('es')->toLetters();
// "Ciento Veintitrés Millones Cuatrocientos Cincuenta Y Seis Mil Setecientos Ochenta Y Nueve Con Doce"

SpellNumber::value(123456789.12)->locale('hi')->toLetters();
// "बारह करोड़ चौंतीस लाख छप्पन हज़ार सात सौ नवासी और बारह"
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

SpellNumber::value(100.12)->locale('hi')->currency('रूपये')->fraction('पैसे')->toMoney();
// "एक सौ रूपये और बारह पैसे"

SpellNumber::value(100)->locale('hi')->currency('रूपये')->toMoney();
// "एक सौ रूपये"

SpellNumber::value(100.65)->locale('pl')->currency('złotych')->fraction('groszy')->toMoney();
// "Sto Złotych I Sześćdziesiąt Pięć Groszy"
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
- [Siros Fakhri](https://github.com/sirosfakhri) (Farsi Language)
- [Ashok Devatwal](https://github.com/ashokdevatwal) (Hindi Language)
- [Olsza](https://github.com/olsza) (Polish Language)
- [Jens Twesmann](https://github.com/jetwes) (German Language)

## License
This project is under the [MIT License](https://choosealicense.com/licenses/mit/).

🌟 Support My Projects! 🚀

[![Become a Sponsor](https://img.shields.io/badge/-Become%20a%20Sponsor-blue?style=for-the-badge&logo=github)](https://github.com/sponsors/rmunate)

Make any contributions you see fit; the code is entirely yours. Together, we can do amazing things and improve the world of development. Your support is invaluable. ✨

If you have ideas, suggestions, or just want to collaborate, we are open to everything! Join our community and be part of our journey to success! 🌐👩‍💻👨‍💻
