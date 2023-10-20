# Convert Numbers to Words in Laravel

Easily convert numbers to words in Laravel using this powerful library, which harnesses the native `PHP INTL` extension to effortlessly perform conversions. With this library, you can convert numbers to words in various languages and even obtain values in currency format tailored to the selected language. Supported languages include English, Spanish, Portuguese, French, Italian, Romanian, Hindi, Polish, and Persian (Farsi).

⚙️ **Compatibility**: This library is compatible with PHP +8.0 and Laravel versions 8.0 and higher. ⚙️

![Spell Number Logo](https://github.com/alejandrodiazpinilla/SpellNumber/assets/51100789/e51cf045-26d0-44e0-a873-3034deaea046)

## Installation

To integrate this library into your project using Composer, simply execute the following command:

```shell
composer require rmunate/spell-number
```

Please ensure that the `intl` extension is enabled and loaded in your environment.

## Usage

> 📖📖📖 **[FULL DOCUMENTATION](https://rmunate.github.io/SpellNumber/)** 📖📖📖

Once the dependency is installed in your project, you can start using it with ease. Here are some examples:

### Languages List with Names

Execute the `getLanguages` command to retrieve an associative array of available languages:

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::getLanguages();

// Result:
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

### Convert Integers to Words

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
```

### Convert Floating-Point Numbers

Should the need arise, you can convert floating-point numbers to words:

```php
SpellNumber::value(123456789.12)->locale('es')->toLetters();
// "Ciento Veintitrés Millones Cuatrocientos Cincuenta Y Seis Mil Setecientos Ochenta Y Nueve Con Doce"

SpellNumber::value(123456789.12)->locale('hi')->toLetters();
// "बारह करोड़ चौंतीस लाख छप्पन हज़ार सात सौ नवासी और बारह"
```

### Convert to Currency Format

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

## Creator

- **Raúl Mauricio Uñate Castro**
- Email: raulmauriciounate@gmail.com

## License

This project is under the [MIT License](https://choosealicense.com/licenses/mit/).

🌟 **Support My Projects!** 🚀

[![Become a Sponsor](https://img.shields.io/badge/-Become%20a%20Sponsor-blue?style=for-the-badge&logo=github)](https://github.com/sponsors/rmunate)

Feel free to contribute, as the code is open to all. Together, we can create amazing things and enhance the world of development. Your support is invaluable. ✨

If you have ideas, suggestions, or wish to collaborate, we are open to everything! Join our community and be part of our journey to success! 🌐👩‍💻👨‍💻