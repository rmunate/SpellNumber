<?php

namespace Rmunate\Utilities\Miscellaneous;

use Illuminate\Support\Str;

final class Replaces
{
    /**
     * Replacements for numbers that are not written literally at the end of a text.
     */
    private const MONEY_CASE = [
        'es' => [
            'uno' => 'un',
        ],
    ];

    /**
     * Replacements where the currency needs to be defined at the end.
     */
    private const MONEY_LOCALE_CASE = [
        'de' => [
            'illion' => 'illion Von',
        ],
        'en' => [
            'illion' => 'illion Of',
        ],
        'es' => [
            'illón'   => 'illón De',
            'illones' => 'illones De',
        ],
        'pt' => [
            'ilhão'  => 'ilhão De',
            'ilhões' => 'ilhões De',
        ],
        'fr' => [
            'illion'  => 'illion De',
            'illions' => 'illions De',
        ],
        'it' => [
            'ilione' => 'ilione Di',
            'ilioni' => 'ilioni Di',
        ],
        'ro' => [
            'ilion'   => 'ilion De',
            'ilioane' => 'ilioane De',
        ],
        'fa' => [
            'ilion'   => 'میلیون و',
        ],
    ];

    /**
     * General replacements to refine each language.
     */
    private const GENERAL_CASE = [
        'es' => [
            'un pesos'    => 'un peso',
            'un centavos' => 'un centavo',
        ],
    ];

    /**
     * Perform replacements in the given text based on the language and current currency.
     *
     * @param string $value   The original text string.
     * @param string $locale  The language of the text.
     * @param string $current The current currency.
     *
     * @throws \InvalidArgumentException If the parameters are invalid.
     *
     * @return string The adjusted text with the replacements performed.
     */
    public static function locale(string $value, string $locale, string $current)
    {
        // Parameter validation
        if (empty($value) || empty($locale) || empty($current)) {
            throw new \InvalidArgumentException('All parameters must have a value.');
        }

        // Replace final strings for each language
        $replacesLocale = self::MONEY_LOCALE_CASE[$locale] ?? [];
        $replacesMoney = self::MONEY_CASE[$locale] ?? [];
        $replacesGeneral = self::GENERAL_CASE[$locale] ?? [];

        foreach ($replacesLocale as $search => $replace) {
            if (substr_compare($value, $search, -strlen($search)) === 0) {
                $value = str_replace($search, $replace, $value);
            }
        }

        foreach ($replacesMoney as $search => $replace) {
            if (substr_compare($value, $search, -strlen($search)) === 0) {
                $value = str_replace($search, $replace, $value);
            }
        }

        // Assign the currency value
        $value = Str::lower($value.' '.$current);

        foreach ($replacesGeneral as $search => $replace) {
            if (substr_compare($value, $search, -strlen($search)) === 0) {
                $value = str_replace($search, $replace, $value);
            }
        }

        // Return the adjusted text
        return $value;
    }
}
