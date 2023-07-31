<?php

namespace Rmunate\Utilities;

use Illuminate\Support\Str;
use Rmunate\Utilities\Langs\Langs;
use Rmunate\Utilities\Bases\BaseSpellNumber;
use Rmunate\Utilities\Miscellaneous\Replaces;
use Rmunate\Utilities\Miscellaneous\Utilities;
use Rmunate\Utilities\Validator\Traits\CommonValidate;
use Rmunate\Utilities\Wrappers\NumberFormatterWrapper;
use Rmunate\Utilities\Exceptions\SpellNumberExceptions;

/**
 * Class SpellNumber
 * This class is used to convert numeric values into their respective textual representation in different languages.
 */
class SpellNumber extends BaseSpellNumber
{
    use CommonValidate;

    /* Default constant values for currency if not defined */
    public const CURRENCY = 'Pesos';
    public const FRACTION = 'Centavos';

    private $value;
    private $type;
    protected $locale;
    protected $currency;
    protected $fraction;

    /**
     * Constructor.
     *
     * @param mixed $value The numeric value to convert to words.
     * @param string $type The type of the value ('integer' or 'double').
     */
    public function __construct($value, $type)
    {
        $this->value = $value;
        $this->type = $type;
        $this->locale = Langs::getLocaleLaravel();
        $this->currency = self::CURRENCY;
        $this->fraction = self::FRACTION;
    }

    /**
     * Convert the numeric value to a fractional value.
     *
     * @param int $value The fractional value to add to the original value.
     * @return SpellNumber The SpellNumber instance with the fractional value added.
     * @throws SpellNumberExceptions If the initial value is already a double value.
     */
    public function fractional(int $value): SpellNumber
    {
        if ($this->type == 'double') {
            throw SpellNumberExceptions::create('The value used initially is already a float value, it is not possible to add other decimals to it.');
        }
        $this->validateInteger();
        $this->validateMaximum();
        $this->value = strval($this->value) . '.' . strval($value);
        $this->type = 'double';
        return $this;
    }

    /**
     * Set the locale for the conversion.
     *
     * @param string $locale The locale to use for the conversion.
     * @return SpellNumber The SpellNumber instance with the updated locale.
     * @throws SpellNumberExceptions If the provided locale is not valid.
     */
    public function locale(string $locale): SpellNumber
    {
        if (!Utilities::isValidLocale($locale)) {
            throw SpellNumberExceptions::create('The provided value is not valid. You can use the getAllLocales() method to see the available options.');
        }
        $this->locale = $locale;
        return $this;
    }

    /**
     * Set the currency for the conversion.
     *
     * @param string $currency The currency to use for the conversion.
     * @return SpellNumber The SpellNumber instance with the updated currency.
     */
    public function currency(string $currency): SpellNumber
    {
        $this->currency = Str::title($currency);
        return $this;
    }

    /**
     * Set the fraction for the conversion.
     *
     * @param string $fraction The fraction to use for the conversion.
     * @return SpellNumber The SpellNumber instance with the updated fraction.
     */
    public function fraction(string $fraction): SpellNumber
    {
        $this->fraction = Str::title($fraction);
        return $this;
    }

    /**
     * Convert the numeric value to words.
     *
     * @return string The textual representation of the numeric value.
     */
    public function toLetters(): string
    {
        return ($this->type == 'integer') ? Str::title($this->integerToLetters()) : Str::title($this->doubleToLetters());
    }

    /**
     * Convert the numeric value to a money representation.
     *
     * @return string The textual representation of the money value.
     */
    public function toMoney(): string
    {
        return ($this->type == 'integer') ? Str::title($this->integerToMoney()) : Str::title($this->doubleToMoney());
    }

    /**
     * Convert the integer numeric value to its textual representation.
     *
     * @return string The textual representation of the integer numeric value.
     */
    private function integerToLetters(): string
    {
        $formatter = NumberFormatterWrapper::format($this->value, $this->locale);
        return $formatter;
    }

    /**
     * Convert the double numeric value to its textual representation.
     *
     * @return string The textual representation of the double numeric value.
     */
    private function doubleToLetters(): string
    {
        $parts = explode('.', $this->value);
        $letters1 = NumberFormatterWrapper::format($parts[0], $this->locale);
        $letters2 = NumberFormatterWrapper::format($parts[1], $this->locale);
        return sprintf('%s %s %s', $letters1, Utilities::connector($this->locale), $letters2);
    }

    /**
     * Convert the integer numeric value to its money representation.
     *
     * @return string The money representation of the integer numeric value.
     */
    private function integerToMoney(): string
    {
        $letters = NumberFormatterWrapper::format($this->value, $this->locale);
        $letters = Replaces::locale($letters, $this->locale, $this->currency);
        return $letters;
    }

    /**
     * Convert the double numeric value to its money representation.
     *
     * @return string The money representation of the double numeric value.
     */
    private function doubleToMoney(): string
    {
        $parts = explode('.', $this->value);
        $letters1 = NumberFormatterWrapper::format($parts[0], $this->locale);
        $letters1 = Replaces::locale($letters1, $this->locale, $this->currency);

        $letters2 = NumberFormatterWrapper::format($parts[1], $this->locale);
        $letters2 = Replaces::locale($letters2, $this->locale, $this->fraction);

        return Str::title($letters1 . ' ' . Utilities::connector($this->locale) . ' ' . $letters2);
    }
}