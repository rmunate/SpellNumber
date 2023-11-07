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
     * @param string $type    The method.
     *
     * @return string The adjusted text with the replacements performed.
     */
    public static function replaceLocale(string $value, string $locale, string $type)
    {
        // Primary Locale
        $locale = Utilities::extractPrimaryLocale($locale);

        //Value
        $value = Str::lower($value);

        // Replace final strings for each language.
        $replacesLocale = Replaces::constant($type)[$locale] ?? [];
        foreach ($replacesLocale as $search => $replace) {
            $search = Str::lower($search);
            $replace = Str::lower($replace);
            $value = str_replace($search, $replace, $value);
        }

        // Return the adjusted text.
        return Str::title($value);
    }

    /**
     * Perform replacements in the given text based on the language and current currency from config file.
     *
     * @param string $value   The original text string.
     * @param string $locale  The language of the text.
     *
     * @return string The adjusted text with the replacements performed.
     */
    public static function replaceFromConfig(string $value, string $locale)
    {
        // Primary Locale
        $locale = Utilities::extractPrimaryLocale($locale);

        //Value
        $value = Str::lower($value);

        //From Config.
        $replacesLocaleConfig = config("spell-number.replacements.$locale") ?? [];
        foreach ($replacesLocaleConfig as $search => $replace) {
            $search = Str::lower($search);
            $replace = Str::lower($replace);
            $value = str_replace($search, $replace, $value);
        }

        // Return the adjusted text.
        return Str::title($value);
    }
}
