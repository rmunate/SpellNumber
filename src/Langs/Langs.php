<?php

namespace Rmunate\Utilities\Langs;

use Rmunate\Utilities\Traits\Locale;

final class Langs
{
    use Locale;

    /**
     * List of time zones available in the package.
     *
     * @var array
     */
    public const LOCALES_AVAILABLE = [
        'de' => 'German',     // German from Germany.
        'en' => 'English',    // English from the United States.
        'es' => 'Spanish',    // Spanish from Spain.
        'fa' => 'Farsi',      // Farsi from Iran.
        'fr' => 'French',     // French from France.
        'hi' => 'Hindi',      // Hindi from India.
        'it' => 'Italian',    // Italian from Italy.
        'pl' => 'Polish',     // Polish from Poland.
        'pt' => 'Portuguese', // Portuguese from Portugal.
        'ro' => 'Romanian',   // Romanian from Romania.
        'vi' => 'Vietnamese', // Vietnamese from Vietnam.
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
        'fa' => 'ممیز', // Farsi from Iran: "ممیز"
        'fr' => 'et',   // French from France: "et"
        'hi' => 'और',   // Hindi from India: "और"
        'it' => 'con',  // Italian from Italy: "con"
        'pl' => 'i',    // Polish from Poland: "i"
        'pt' => 'com',  // Portuguese from Portugal: "com"
        'ro' => 'cu',   // Romanian from Romania: "cu"
        'vi' => 'và',   // Vietnamese from Vietnam: "và"
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
        'fa' => 'از',   // Farsi from Iran: "از"
        'fr' => 'de',   // French from France: "de"
        'hi' => 'का',   // Hindi from India: "का"
        'it' => 'di',   // Italian from Italy: "di"
        'pl' => 'i',    // Polish from Poland: "i"
        'pt' => 'de',   // Portuguese from Portugal: "de"
        'ro' => 'de',   // Romanian from Romania: "de"
        'vi' => 'của',  // Vietnamese from Vietnam: "của"
    ];
}
