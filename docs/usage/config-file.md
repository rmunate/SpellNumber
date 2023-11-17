---
title: Config File
editLink: true
outline: deep
---

# Config File

Since version 4.0 of the package, you will have the option to configure your environment so that the translations are easier to write in your controllers or classes, now you will have a file inside the `config` folder that will allow you to adjust by default the values to be used in the conversions.

You will also have a unique functionality, where you can create your own logic for any output of the values processed in the package.

## Export file from vendor to project

To export the configuration file from the vendor to the `config` folder, you can use the command:

``` bash
php artisan vendor:publish --provider="Rmunate\\Utilities\\Providers\\SpellNumberProvider" --tag="config"
```

## Locale.

Now that you have the `spell-number.php` file in the `config` folder, you can adjust the language that will be used for all translations of the package from numbers to letters, avoiding having to use it when invoking the use of the library.

``` php
return [
  //...
  'default' => [
    //...
      'locale' => 'en',
    //... 
    ]
]
```

In the index `locale` you can assign the one you are going to use globally.

## Specific Locale

By default the package only works with the list of supported languages, a list that can be obtained with the `SpellNumber::getAvailableLocales()` method, now if what you are looking for is to use a more precise `locale`, such as `es_CO`, `es_MX`,`en_US`, in that case you can leave this configuration defined to avoid having to pass the constant `SpellNumber::SPECIFIC_LOCALE` in the `->locale(...)` method.

``` php
return [
  //...
  'default' => [
    //...
      'specific_locale' => true, //false (default)
    //... 
    ]
]
```

## Currency Values

Just as you can set the global translation language, you can also define the currency values that should be used in all library processing outputs.

``` php
return [
  //...
  'default' => [
    //...
      'currency' => 'dollars',
    //... 
      'fraction' => 'cents',
    //... 
    ]
]
```

## Output type ordinal texts

If you are going to use the package to generate ordinal values, in that case you can also determine a global output for all calls of the method, for that you can define the output mode of the ordinal text from the configuration file, this avoids you having to go through the `SpellNumber::ORDINAL_DEFAULT`, `SpellNumber::ORDINAL_MALE`, `SpellNumber::ORDINAL_FEMALE` constants in the `->toOrdinal()` method.

``` php
return [
  //...
  'default' => [
    //...
      'ordinal_output' => 'default', // 'default', 'male', 'female'
    //... 
    ]
]
```

## Replacements

Some people around the world have seen that some small fragments of the packet processing outputs must conform to the current language of the country or region, usually they are small fragments that could be replaced by a specific term or form of writing, for that you now have the possibility of defining all the replacements of text fragments that you consider necessary.

Relying on the structure of an associative array, you will put the value to be searched as an index and the text to be assigned as its replacement as a value.

The primary value must be there, that is, "es" instead of "es_MX" or similar.

``` php
return [
  //...
  'replacements' => [
      'es' => [
          'uno' => 'un', 
      ],
  ],
]
```

You must define the language on which the replacement should be applied in all the outputs of the internal processing of the package.

## Callback

If what you would like is to have a programmable way to modify the output of the package value, in that case this solution is what you need.

Go to the next page =>