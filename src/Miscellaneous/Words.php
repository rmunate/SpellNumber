<?php

namespace Rmunate\Utilities\Miscellaneous;

use Illuminate\Support\Str;
use Rmunate\Utilities\Langs\Replaces;

final class Words
{
    /**
     * Perform replacements in the given text based on the language and current currency.
     *
     * @param string $value   The original text string.
     * @param string $locale  The language of the text.
     * @param string $current The current currency.
     *
     * @return string The adjusted text with the replacements performed.
     */
    public static function locale(string $value, string $locale, string $current)
    {
        // Replace final strings for each language
        $replacesLocale = Replaces::TO_MONEY[$locale] ?? [];
        foreach ($replacesLocale as $search => $replace) {
            if (substr_compare($value, $search, -strlen($search)) === 0) {
                $value = str_replace($search, $replace, $value);
            }
        }

        // Assign the currency value
        $replacesGeneral = Replaces::GENERAL[$locale] ?? [];
        $value = Str::lower($value.' '.$current);
        foreach ($replacesGeneral as $search => $replace) {
            if (substr_compare($value, $search, -strlen($search)) === 0) {
                $value = str_replace($search, $replace, $value);
            }
        }

        //From Config
        $replacesLocaleConfig = config("spell-number.replacements.$locale") ?? [];
        foreach ($replacesLocaleConfig as $search => $replace) {
            if (substr_compare($value, $search, -strlen($search)) === 0) {
                $value = str_replace($search, $replace, $value);
            }
        }

        // Return the adjusted text
        return $value;
    }
}
