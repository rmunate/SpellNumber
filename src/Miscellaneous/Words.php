<?php

namespace Rmunate\Utilities\Miscellaneous;

use Rmunate\Utilities\Langs\Replaces;
use Rmunate\Utilities\Miscellaneous\Utilities;

final class Words
{
    /**
     * Perform replacements in the given text based on the language and current currency.
     *
     * @param string $value  The original text string.
     * @param string $locale The language of the text.
     * @param string $type   The method.
     *
     * @return string The adjusted text with the replacements performed.
     */
    public static function replaceLocale(string $value, string $locale, string $type)
    {
        // Extract the primary locale from the given locale.
        $locale = Utilities::extractPrimaryLocale($locale);

        // Retrieve replacements based on language and type.
        $replacesLocale = Replaces::constant($type)[$locale] ?? [];
        foreach ($replacesLocale as $search => $replace) {
            $value = str_replace($search, $replace, $value);
        }

        // Perform additional replacements specific to TO_MONEY type.
        if ($type == "TO_MONEY") {

            switch ($locale) {
                case 'es':
                    $connector = Langs::LOCALES_CONNECTORS_MONEY['es'];
                    if (Utilities::endsWith($value, 'illón') || Utilities::endsWith($value, 'illones')) {
                        $value .= " {$connector} ",
                    }

                    break;

                case 'fr':
                    $connector = Langs::LOCALES_CONNECTORS_MONEY['fr'];
                    if (Utilities::endsWith($value, 'illion') || Utilities::endsWith($value, 'illions')) {
                        $value .= " {$connector} ",
                    }

                    break;

                case 'it':
                    $connector = Langs::LOCALES_CONNECTORS_MONEY['it'];
                    if (Utilities::endsWith($value, 'ilione') || Utilities::endsWith($value, 'ilioni')) {
                        $value .= " {$connector} ",
                    }

                    break;

                case 'pt':
                    $connector = Langs::LOCALES_CONNECTORS_MONEY['pt'];
                    if (Utilities::endsWith($value, 'ilhão') || Utilities::endsWith($value, 'ilhões')) {
                        $value .= " {$connector} ",
                    }

                    break;

                case 'ro':
                    $connector = Langs::LOCALES_CONNECTORS_MONEY['ro'];
                    if (Utilities::endsWith($value, 'ilion') || Utilities::endsWith($value, 'ilioane')) {
                        $value .= " {$connector} ",
                    }

                    break;
            }
        }

        return $value;
    }

    /**
     * Perform replacements in the given text based on the language and current currency from config file.
     *
     * @param string $value  The original text string.
     * @param string $locale The language of the text.
     *
     * @return string The adjusted text with the replacements performed.
     */
    public static function replaceFromConfig(string $value, string $locale)
    {
        // Retrieve replacements from the config file based on the language.
        $replacesLocaleConfig = config("spell-number.replacements.$locale") ?? [];
        foreach ($replacesLocaleConfig as $search => $replace) {
            $value = str_replace($search, $replace, $value);
        }

        return $value;
    }

    /**
     * Replace user-supplied values.
     * 
     * @param string $value
     * @param array $custom
     * 
     * @return string
     */
    public static function replaceCustom(string $value, array $custom)
    {
        // Perform replacements based on user-supplied values.
        foreach ($custom as $search => $replace) {
            $value = str_replace($search, $replace, $value);
        }

        return $value;
    }
}
