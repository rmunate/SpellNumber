# Supported Languages

We currently have 10 supported languages to easily work with this package. Below we list the configured languages:

- German 
- English 
- Spanish 
- Farsi 
- French 
- Hindi 
- Italian 
- Polish 
- Portuguese 
- Romanian 

If you want to get the supported languages directly from the package, you have two ways to do it.

## Languages List
Execute the command `getAllLocales`, as output it will give you an array with the available values.

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::getAllLocales();

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
// ]
```

## Languages List Whit Name

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