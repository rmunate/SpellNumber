# Convert Numbers to Words in Laravel

Easily convert numbers to words in Laravel using this library, which supports the native PHP INTL extension to perform the conversion seamlessly. This library allows you to convert numbers to words in multiple languages and also get the value in currency format based on the selected language. Supported languages include English, Spanish, Portuguese, French, Italian, and Romanian.

⚙️ This library is compatible with Laravel versions 8.0 and higher ⚙️

![Laravel 8.0+](https://img.shields.io/badge/Laravel-8.0%2B-orange.svg)
![Laravel 9.0+](https://img.shields.io/badge/Laravel-9.0%2B-orange.svg)
![Laravel 10.0+](https://img.shields.io/badge/Laravel-10.0%2B-orange.svg)

![SpellNumbers](https://github.com/rmunate/SpellNumber/assets/91748598/f2aea68b-fc9f-46be-ae54-a4955f0ce7a2)

## Table of Contents
- [Installation](#installation)
- [Usage](#usage)
- [Creator](#creator)
- [License](#license)

## Installation
To install the dependency via Composer, execute the following command:

```shell
composer require rmunate/spell-number
```

Make sure that the `intl` extension is enabled and loaded in your environment.

## Usage
After installing the dependency in your project, you can start using it with the following examples:

```php
// GET AVAILABLE LOCALES
SpellNumber::getAllLocales();
// array:6 [▼ //
//     0 => "en"
//     1 => "es"
//     2 => "pt"
//     3 => "fr"
//     4 => "it"
//     5 => "ro"
// ]

// CONVERT INTEGER TO WORDS
SpellNumber::value(100)->locale('en')->toLetters();
// "One Hundred"
SpellNumber::value(12300000)->locale('en')->toLetters();
// "Twelve Million Three Hundred Thousand"

// CONVERT FLOAT TO WORDS
SpellNumber::value(123456789.12)->locale('en')->toLetters();
// "One Hundred Twenty-Three Million Four Hundred Fifty-Six Thousand Seven Hundred Eighty-Nine Point Twelve"

// CONVERT INTEGER TO CURRENCY TEXT FORMAT
SpellNumber::value(100)->locale('en')->currency('dollars')->toMoney();
// "One Hundred Dollars"
SpellNumber::value(100.12)->locale('en')->currency('Dollars')->fraction('cents')->toMoney();
// "One Hundred Dollars and Twelve Cents"

// OTHER STARTING METHODS

// Integer, this method strictly requires an integer value as an argument.
SpellNumber::integer(100)->locale('en')->toLetters();

// Floats, this method strictly requires a string value as an argument.
SpellNumber::float('12345.23')->locale('en')->toLetters();
```

## Creator
- 🇨🇴 Raúl Mauricio Uñate Castro
- Email: raulmauriciounate@gmail.com

## License
This project is under the [MIT License](https://choosealicense.com/licenses/mit/).