<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Global Configuration for Number to Words Conversion.
    |--------------------------------------------------------------------------
    |
    | Visit https://rmunate.github.io/SpellNumber/ for detailed documentation.
    | Define a global configuration to facilitate and expedite the translation of values to words.
    |
    */

    'default' => [

        /*
        |--------------------------------------------------------------------------
        | Default Locale for Number to Words Translation.
        |--------------------------------------------------------------------------
        |
        | Define the language over which values will be translated to words.
        |
        */

        'locale' => 'en',

        /*
        |--------------------------------------------------------------------------
        | Define the Currency.
        |--------------------------------------------------------------------------
        |
        | Define the name of the currency to use globally.
        | This will reduce the amount of code when using the library.
        |
        */

        'currency' => 'dollars',

        /*
        |--------------------------------------------------------------------------
        | Define the Fraction.
        |--------------------------------------------------------------------------
        |
        | Define the name of the currency fraction to use globally.
        | This will reduce the amount of code when using the library.
        | Cents? What will you use?.
        |
        */

        'fraction' => 'cents',

        /*
        |--------------------------------------------------------------------------
        | Output type ordinal texts
        |--------------------------------------------------------------------------
        |
        | The output usually depends on the language to be used,
        | so you can use any of the following three options.
        |
        | Options: 'default', 'male', 'female'
        |
        */

        'ordinal_output' => 'default',
    ],

    /*
    |--------------------------------------------------------------------------
    | Global Output Replacements
    |--------------------------------------------------------------------------
    |
    | If you need to make any replacements to the translation output, which is common
    | in cases with abbreviated numbers or other language contractions, you can
    | easily do so here through an associative array.
    |
    | Remember that the main index should match the locale you are using.
    |
    */

    'replacements' => [
        // 'en' => [
        //     'that' => 'this',
        // ],
    ],

];