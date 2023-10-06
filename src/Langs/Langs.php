<?php

namespace Rmunate\Utilities\Langs;

use Illuminate\Support\Facades\App;

final class Langs
{
    /**
     * Array containing supported locales in ISO 639-1 format.
     *
     * @var array
     */
    public const LOCALES = [
        'de', // German from Germany
        'en', // English from the United States
        'es', // Spanish from Spain
        'pt', // Portuguese from Portugal
        'fr', // French from France
        'it', // Italian from Italy
        'ro', // Romanian from Romania
        'fa', // Farsi from Iran
        'hi', // Hindi from India
        'pl', // Polish from Poland
    ];

    /**
     * Array containing connectors for each language.
     *
     * @var array
     */
    public const LOCALES_CONNECTORS = [
        'de' => 'und',  // German from Germany: "und"
        'en' => 'and',  // English from the United States: "and"
        'es' => 'con',  // Spanish from Spain: "con"
        'pt' => 'com',  // Portuguese from Portugal: "com"
        'fr' => 'et',   // French from France: "et"
        'it' => 'con',  // Italian from Italy: "con"
        'ro' => 'cu',   // Romanian from Romania: "cu"
        'fa' => 'ممیز', // Farsi from Iran: "ممیز"
        'hi' => 'और',   // Hindi from India: "और"
        'pl' => 'i',    // Polish from Poland: "i"
    ];

    /**
     * Array containing connectors for each language used when representing money.
     *
     * @var array
     */
    public const LOCALES_CONNECTORS_MONEY = [
        'de' => 'von',  // German frm Germany: "von"
        'en' => 'of',   // English from the United States: "of"
        'es' => 'de',   // Spanish from Spain: "de"
        'pt' => 'de',   // Portuguese from Portugal: "de"
        'fr' => 'de',   // French from France: "de"
        'it' => 'di',   // Italian from Italy: "di"
        'ro' => 'de',   // Romanian from Romania: "de"
        'fa' => 'از',   // Farsi from Iran: "از"
    ];

    /**
     * Get the language locale used in Laravel application.
     * If the locale is supported in ISO 639-1 format, return it. Otherwise, return the default.
     */
    public static function getLocaleLaravel()
    {
        $localeLaravel = App::getLocale();
        $iso639_1 = substr($localeLaravel, 0, 2);

        if (in_array($iso639_1, self::LOCALES)) {
            return $iso639_1;
        }

        // Return the default locale if not found in supported locales.
        return self::LOCALES[0];
    }
}
