<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Global Configuration for SpellNumber v4.3.0 Output
    |--------------------------------------------------------------------------
    |
    | Visit the official documentation at https://rmunate.github.io/SpellNumber/
    | for detailed information on package usage.
    |
    */

    'default' => [

        /*
        |--------------------------------------------------------------------------
        | Global Configuration for Locale
        |--------------------------------------------------------------------------
        |
        | Defines the global output locale for package translations.
        | By using this setting, you can omit the locale(...) method in package usage.
        |
        */

        'locale' => 'en',

        /*
        |--------------------------------------------------------------------------
        | Define Global Output for Currency Type
        |--------------------------------------------------------------------------
        |
        | Defines the global output for converting numbers to words in currency format.
        | With this global configuration, you can avoid using the currency(...) method
        | in package usage.
        |
        */

        'currency' => 'dollars',

        /*
        |--------------------------------------------------------------------------
        | Define Output for Currency Fraction
        |--------------------------------------------------------------------------
        |
        | Defines the global output for currency fractions when the supplied value is
        | in floating-point format (double|float). With this configuration, you can avoid
        | using the fraction(...) method in package usage.
        |
        */

        'fraction' => 'cents',

        /*
        |--------------------------------------------------------------------------
        | Global Configuration for Ordinal Values
        |--------------------------------------------------------------------------
        |
        | Defines the global output for ordinal numbers. This varies by language;
        | for English, use 'default', while for romance languages, you may choose
        | between masculine and feminine forms.
        | Options: 'default', 'male', 'female'
        |
        */

        'ordinal_output' => 'default',
    ],

    /*
    |--------------------------------------------------------------------------
    | Replacements in Translation Output
    |--------------------------------------------------------------------------
    |
    | Sometimes, in certain languages, the output may not be exact, or there might
    | be changes due to regional variations, such as contracted or abbreviated numbers.
    |
    | Here, you can define global replacements for outputs. Simply set the language
    | as the index to apply changes.
    |
    */

    'replacements' => [
        // 'en' => [
        //     'that' => 'this',
        // ],
    ],

];