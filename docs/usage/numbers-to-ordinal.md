---
outline: deep
---

# Numbers To Letters

## Method Value

### Integers

You can easily convert whole numbers to words by defining the locale to be applied. If you do not define a locale, "en" (English) will be applied by default. Remember that if you export the vendor configuration file, it will not require this definition.

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::value(100)->locale('en')->toLetters();
// "One Hundred"

SpellNumber::value(100)->locale('es')->toLetters();
// "Cien"

SpellNumber::value(100)->locale('fa')->toLetters();
// "صد"

SpellNumber::value(100)->locale('hi')->toLetters();
// "एक सौ"
```

## Method Integer

You can also rely on the `Integer` method to define that the input is a new integer.
Remember to ensure that the input value is of type `int`.

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::integer(100)->locale('en')->toLetters();
// "One Hundred"

SpellNumber::integer(2)->locale('es')->toLetters();
// "Segundo"
```
