# Convert Numbers to Words in Laravel

## Introduction

Easily convert numbers to words in Laravel using this library, which leverages the native `PHP INTL` extension to perform conversion effortlessly. With this library, you can convert numbers to words in various languages and also obtain the value in currency format according to the selected language. Supported languages include English, Spanish, Portuguese, French, Italian, Romanian, Hindi, Polish and Persian (Farsi).

**This library is compatible with PHP +8.0 and Laravel versions 8.0 and higher**

![Spell Number Logo](https://github.com/alejandrodiazpinilla/SpellNumber/assets/51100789/e51cf045-26d0-44e0-a873-3034deaea046)

## Requirements

For this solution to work properly you must have at least a version of PHP 8.0 since the package in its CORE has typed data.

You must have Laravel Framework version 8 or higher.

Finally, our package relies on the native PHP `INTL` extension, check in your `php.ini` that you have it.

## Install

### Composer

To install the dependency via Composer, execute the following command:

``` bash
composer require rmunate/spell-number
```

The package will automatically register itself.

**That's all!**

## Usage

[![📖📖📖 **FULL DOCUMENTATION** 📖📖📖](https://img.shields.io/badge/FULL%20DOCUMENTATION-Visit%20Here-blue?style=for-the-badge)](https://rmunate.github.io/SpellNumber/)


Once the dependency is installed in your project, you can start using it with ease. Here are some examples:

### Languages List with Names

Execute the `getLanguages` command to retrieve an associative array of available languages:

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::getLanguages();
```

### Convert Numbers To Letters

Easily convert numbers to words by specifying the desired regional configuration. If not specified, "en" (English) is used by default:

```php
SpellNumber::value(100)->locale('es')->toLetters();
// "Cien"

SpellNumber::value(100)->locale('fa')->toLetters();
// "صد"

SpellNumber::value(100)->locale('en')->toLetters();
// "One Hundred"

SpellNumber::value(100)->locale('hi')->toLetters();
// "एक सौ"

SpellNumber::value(123456789.12)->locale('es')->toLetters();
// "Ciento Veintitrés Millones Cuatrocientos Cincuenta Y Seis Mil Setecientos Ochenta Y Nueve Con Doce"

SpellNumber::value(123456789.12)->locale('hi')->toLetters();
// "बारह करोड़ चौंतीस लाख छप्पन हज़ार सात सौ नवासी और बारह"
```

### Convert Numbers To Money

For scenarios like invoices and receipts, obtain values in currency format:

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

# Contributing 

If you want to add support for a new language or want to develop new features, you can submit your requests to the main branch of the repository.

To date, the following world-class developers have contributed their knowledge.

To whom we thank for supporting making programming easier.

- [Ashok Devatwal](https://github.com/ashokdevatwal) (Hindi Language)
- [Olsza](https://github.com/olsza) (Polish Language)
- [Jens Twesmann](https://github.com/jetwes) (German Language)
- [Gabriel Rausch](https://github.com/gdsrmygdsrjr) (Zero Decimal Correction)
- [Alejandro Diaz](https://github.com/alejandrodiazpinilla) (Readme And Icon)
- [Frank Sepulveda](https://github.com/socieboy) (Ordinal Texts)

## License
This project is under the [MIT License](https://choosealicense.com/licenses/mit/).

🌟 Support My Projects! 🚀

[![Become a Sponsor](https://img.shields.io/badge/-Become%20a%20Sponsor-blue?style=for-the-badge&logo=github)](https://github.com/sponsors/rmunate)

Make any contributions you see fit; the code is entirely yours. Together, we can do amazing things and improve the world of development. Your support is invaluable. ✨

If you have ideas, suggestions, or just want to collaborate, we are open to everything! Join our community and be part of our journey to success! 🌐👩‍💻👨‍💻