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
        'en',    // English from the United States
        'es',    // Spanish from Spain
        'pt',    // Portuguese from Portugal
        'fr',    // French from France
        'it',    // Italian from Italy
        'ro',    // Romanian from Romania
    ];

    /**
     * Array containing connectors for each language.
     * 
     * @var array
     */
    public const LOCALES_CONNECTORS = [
        'en' => "and",   // English from the United States: "and"
        'es' => "con",   // Spanish from Spain: "con"
        'pt' => "com",   // Portuguese from Portugal: "com"
        'fr' => "et",    // French from France: "et"
        'it' => "con",   // Italian from Italy: "con"
        'ro' => "cu",    // Romanian from Romania: "cu"
    ];

    /**
     * Array containing connectors for each language used when representing money.
     * 
     * @var array
     */
    public const LOCALES_CONNECTORS_MONEY = [
        'en' => "of",   // English from the United States: "of"
        'es' => "de",   // Spanish from Spain: "de"
        'pt' => "de",   // Portuguese from Portugal: "de"
        'fr' => "de",    // French from France: "de"
        'it' => "di",   // Italian from Italy: "di"
        'ro' => "de",    // Romanian from Romania: "de"
    ];

    /**
     * Get the language locale used in Laravel application.
     * If the locale is supported in ISO 639-1 format, return it. Otherwise, return the default.
     *
     * @return string
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
