# Convert Numbers to Words in Laravel

Easily convert numbers to words in Laravel using this library, which leverages the native `PHP INTL` extension to perform conversion effortlessly. With this library, you can convert numbers to words in various languages and also obtain the value in currency format according to the selected language. Supported languages include English, Spanish, Portuguese, French, Italian, Romanian, Hindi, Polish and Persian (Farsi).

⚙️ This library is compatible with PHP +8.0 and Laravel versions 8.0 and higher ⚙️

![logo-spell-number](https://github.com/alejandrodiazpinilla/SpellNumber/assets/51100789/e51cf045-26d0-44e0-a873-3034deaea046)

## Installation

To install the dependency via Composer, execute the following command:

```shell
composer require rmunate/spell-number
```

It's important to ensure that the `intl` extension is enabled and loaded in the environment.

## Usage

> SEE 📖📖📖 [FULL DOCUMENTATION](https://rmunate.github.io/SpellNumber/) 📖📖📖

After installing the dependency in your project, you can start using it with the following examples:

#### Languages List Whit Name

Execute the command `getLanguages`, as output it will give you an associative array with the values of available languages.

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::getLanguages();

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


## Creator
- Raúl Mauricio Uñate Castro
- Email: raulmauriciounate@gmail.com

## License
This project is under the [MIT License](https://choosealicense.com/licenses/mit/).

🌟 Support My Projects! 🚀

[![Become a Sponsor](https://img.shields.io/badge/-Become%20a%20Sponsor-blue?style=for-the-badge&logo=github)](https://github.com/sponsors/rmunate)

Make any contributions you see fit; the code is entirely yours. Together, we can do amazing things and improve the world of development. Your support is invaluable. ✨

If you have ideas, suggestions, or just want to collaborate, we are open to everything! Join our community and be part of our journey to success! 🌐👩‍💻👨‍💻
