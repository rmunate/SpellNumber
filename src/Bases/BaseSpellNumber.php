<?php

namespace Rmunate\Utilities\Bases;

use Rmunate\Utilities\Langs\Langs;
use Rmunate\Utilities\Validator\SpellNumberValidator;

abstract class BaseSpellNumber
{   
    /**
     * Creates an instance of the child class with the provided value for conversion.
     *
     * @param mixed  $value  The numeric value to convert to words.
     * @param string $locale The locale to use for conversion. Default is 'es_ES' (Spanish).
     *
     * @throws SpellNumberExceptions When the Intl extension is not available or the value is not valid (integer or double).
     *
     * @return static An instance of the child class.
     */
    public static function value(mixed $value)
    {
        $type = SpellNumberValidator::check('mixed', $value)->result();

        return new static($value, $type);
    }

    /**
     * Creates an instance of the child class with the provided integer value for conversion.
     *
     * @param int $value The integer value to convert to words.
     *
     * @throws SpellNumberExceptions When the Intl extension is not available or the value is not a valid integer.
     *
     * @return static An instance of the child class.
     */
    public static function integer(int $value)
    {
        SpellNumberValidator::check('integer', $value)->result();

        return new static($value, 'integer');
    }

    /**
     * Creates an instance of the child class with the provided float value for conversion.
     *
     * @param float $value The float value to convert to words.
     *
     * @throws SpellNumberExceptions When the Intl extension is not available or the value is not a valid float.
     *
     * @return static An instance of the child class.
     */
    public static function float(string|float $value)
    {
        SpellNumberValidator::check('double', $value)->result();

        return new static($value, 'double');
    }

    /**
     * Creates an instance of the child class with the provided text value for conversion.
     *
     * @param string $text The text value to be processed.
     *
     * @return static An instance of the child class configured for text processing.
     */
    public static function text(string $text)
    {
        return new static($text, 'text');
    }

    /**
     * Creates an instance of the child class with the provided date value for conversion.
     *
     * @param string $date The date value to be processed.
     *
     * @return static An instance of the child class configured for date processing.
     */
    public static function date(string $date)
    {
        return new static($date, 'date');
    }

    /**
     * Returns the list of available premises according to PHP.
     *
     * @return array An array containing all locales.
     */
    public static function getAllLocales()
    {
        try {
            $availableLocales = \ResourceBundle::getLocales('');

            return $availableLocales;
        } catch (\Throwable $th) {
            return array_keys(Langs::LOCALES_AVAILABLE);
        }
    }

    /**
     * Retrieves a list of all available locales supported by the NumberFormatter class.
     *
     * @return array An array containing all available locales.
     */
    public static function getAvailableLocales()
    {
        return array_keys(Langs::LOCALES_AVAILABLE);
    }

    /**
     * Retrieves a list of all available TimeZones by the NumberFormatter class.
     *
     * @return array An array containing all available locales.
     */
    public static function getAvailableLanguages()
    {
        return Langs::LOCALES_AVAILABLE;
    }

    /**
     * This method allows querying the constants existing within SpellNumber
     * along with their values for use in the package.
     *
     * @param string|null $category The optional category of constants to retrieve.
     *
     * @return mixed
     */
    public static function getConstants(?string $category = null)
    {
        $data = [
            "spell" => [
                "SpellNumber::TO_LETTERS" => "%value-to-letters",
                "SpellNumber::TO_ORDINAL" => "%value-to-ordinal",
                "SpellNumber::TO_MONEY" => "%value-to-money",
                "SpellNumber::TO_CLOCK" => "%value-to-clock",
                "SpellNumber::TO_SCIENTIFIC" => "%value-to-scientific",
                "SpellNumber::TO_PERCENT" => "%value-to-percent",
                "SpellNumber::TO_CURRENCY" => "%value-to-currency",
                "SpellNumber::TO_SUMMARY" => "%value-to-summary",
                "SpellNumber::TO_ROMAN_NUMERAL" => "%value-to-roman-numeral",
            ],
            "ordinal-numbers" => [
                "SpellNumber::ORDINAL_DEFAULT" => '%spellout-ordinal',
                "SpellNumber::ORDINAL_FEMALE" => '%spellout-ordinal-feminine',
                "SpellNumber::ORDINAL_MALE" => '%spellout-ordinal-masculine',
            ],
            "date" => [
                "SpellNumber::DATE_SHORT" => "%date-format-short",
                "SpellNumber::DATE_MEDIUM" => "%date-format-medium",
                "SpellNumber::DATE_LONG" => "%date-format-long",
                "SpellNumber::DATE_FULL" => "%date-format-full",
            ],
        ];

        $output = !empty($category) ? ($data[$category] ?? []) : $data;

        return json_decode(json_encode($output), false);
    }
}
