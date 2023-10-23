<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Global Configuration for Number to Words Conversion.
    |--------------------------------------------------------------------------
    |
    | Define a global configuration to make the translation of values to words easier and faster.
    |
    */

    'default' => [

        /*
        |--------------------------------------------------------------------------
        | Default Locale for Number to Words Translation.
        |--------------------------------------------------------------------------
        |
        | Define the language over which values will be translated to words.
        | Remember that you only have the following options available:
        | 'de', 'en', 'es', 'fa', 'fr', 'hi', 'it', 'pl', 'pt', 'ro'.
        |
        */

        'lang' => 'en',

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
    ],

    /*
    |--------------------------------------------------------------------------
    | Sometimes you need to replace certain things in the number to words outputs.
    |--------------------------------------------------------------------------
    |
    | If so, it's very easy to do.
    | Use the structure of an associative array to apply these replacements to your outputs.
    |
    */

    'replacements' => [
        // 'en' => [
        //     'that' => 'this',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Encountered a specific adjustment in the number to words output?.
    |--------------------------------------------------------------------------
    |
    | Here, you have the option to adjust whatever you need, the best part!
    | This adjustment will apply to all your number to words outputs.
    |
    */

    'callback_output' => function ($data) {
        // Your logic here...

        return $data->getWords();
    },
];
