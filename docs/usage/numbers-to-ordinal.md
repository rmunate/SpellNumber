---
title: Numbers To Ordinal
editLink: true
outline: deep
---

# Numbers To Ordinal

You may need to list some data within your system, if so, this section is your solution.

This package included the option to use ordinal numbers for this purpose.

You can only use this method with integers, remember to ensure that the value meets this type, otherwise we may have unexpected responses.

## Method Value

You can easily convert integers. If you do not define a locale, "en" (English) will be applied by default. Remember that if you export the provider configuration file, it will not require this definition.

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::value(2)->locale('en')->toOrdinal();
// "second"

SpellNumber::value(2)->locale('en')->toOrdinal(SpellNumber::ORDINAL_DEFAULT);
// "second"

SpellNumber::value(2)->locale('es')->toOrdinal(SpellNumber::ORDINAL_MALE);
// "segundo"

SpellNumber::value(2)->locale('es')->toOrdinal(SpellNumber::ORDINAL_FEMALE);
// "segunda"
```

## Method Integer

You can also rely on the `Integer` method to define that the input is a new integer.
Remember to ensure that the input value is of type `int`.

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::integer(2)->locale('en')->toOrdinal();
// "second"

SpellNumber::integer(2)->locale('en')->toOrdinal(SpellNumber::ORDINAL_DEFAULT);
// "second"

SpellNumber::integer(2)->locale('es')->toOrdinal(SpellNumber::ORDINAL_MALE);
// "segundo"

SpellNumber::integer(2)->locale('es')->toOrdinal(SpellNumber::ORDINAL_FEMALE);
// "segunda"
```

## Especific Locale

If you want to use a specific locale, you should always use the constant `SpellNumber::SPECIFIC_LOCALE`

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::value(2)->locale('en_US', SpellNumber::SPECIFIC_LOCALE)->toOrdinal();
// "second"

SpellNumber::integer(2)->locale('es_MX', SpellNumber::SPECIFIC_LOCALE)->toOrdinal(SpellNumber::ORDINAL_FEMALE)
// "segunda"
```