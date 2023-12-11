<?php

namespace Rmunate\Utilities\Bases;

use Rmunate\Utilities\Langs\Langs;
use Rmunate\Utilities\Validator\SpellNumberValidator;

/**
 * Base class for SpellNumber operations.
 */
abstract class BaseSpellNumber
{   
    /**
     * Return a new instance of SpellNumber after analyzing the data type to be processed.
     *
     * @param mixed $value Value to process; should be integer or double.
     *
     * @return static SpellNumber class.
     */
    public static function value(mixed $value)
    {
        $type = SpellNumberValidator::check('mixed', $value)->result();
        return new static($value, $type);
    }

    /**
     * Return an instance of the child class, indicating that it is an integer value.
     *
     * @param int $value Integer value to process.
     *
     * @return static SpellNumber class.
     */
    public static function integer(int $value)
    {
        SpellNumberValidator::check('integer', $value)->result();
        return new static($value, 'integer');
    }

    /**
     * Return an instance of the child class, indicating that the value to process is a double.
     *
     * @param float $value Value to process.
     *
     * @return static SpellNumber class.
     */
    public static function float(string|float $value)
    {
        SpellNumberValidator::check('double', $value)->result();
        return new static($value, 'double');
    }

    /**
     * Return an instance of the child class to convert from text to numbers.
     *
     * @param string $text Alphabetic value to convert to numbers.
     *
     * @return static SpellNumber class.
     */
    public static function text(string $text)
    {
        SpellNumberValidator::check('text', $text)->result();
        return new static($text, 'text');
    }

    /**
     * Return an instance of the child class for date format processing.
     *
     * @param string $date The date value to be processed.
     *
     * @return static An instance of the child class configured for date processing.
     */
    public static function date(string $date)
    {
        SpellNumberValidator::check('date', $date)->result();
        return new static($date, 'date');
    }

    /**
     * Return an array containing all locales.
     *
     * @return array An array containing all locales.
     */
    public static function getAllLocales()
    {
        try {
            return \ResourceBundle::getLocales('');
        } catch (\Throwable $th) {
            return array_keys(Langs::LOCALES_AVAILABLE);
        }
    }

    /**
     * Return an array of languages with preconfigured text output settings.
     *
     * @return array An array containing all available locales.
     */
    public static function getAvailableLocales()
    {
        return array_keys(Langs::LOCALES_AVAILABLE);
    }

    /**
     * Return an array where each entry contains the language code and the full language name.
     *
     * @return array An array containing all available locales.
     */
    public static function getAvailableLanguages()
    {
        return Langs::LOCALES_AVAILABLE;
    }

    /**
     * Return a list of constants configured in the SpellNumber class.
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
