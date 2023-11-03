<?php

namespace Rmunate\Utilities;

use Illuminate\Support\Str;
use Rmunate\Utilities\Langs\Langs;
use Illuminate\Support\Traits\Macroable;
use Rmunate\Utilities\Miscellaneous\Words;
use Rmunate\Utilities\Bases\BaseSpellNumber;
use Rmunate\Utilities\Callback\DataResponse;
use Rmunate\Utilities\Miscellaneous\Utilities;
use Rmunate\Utilities\Validator\Traits\CommonValidate;
use Rmunate\Utilities\Wrappers\NumberFormatterWrapper;
use Rmunate\Utilities\Exceptions\SpellNumberExceptions;

class SpellNumber extends BaseSpellNumber
{
    use CommonValidate;
    use Macroable;

    /* Constants Locale */
    public const SPECIFIC_LOCALE = true;

    /* Constants Ordinal Text */
    public const ORDINAL_DEFAULT = '%spellout-ordinal';
    public const ORDINAL_MALE = '%spellout-ordinal-masculine';
    public const ORDINAL_FEMALE = '%spellout-ordinal-feminine';

    /* Propierties */
    private $value;
    private string $type;
    protected string $locale;
    protected string $currency;
    protected string $fraction;

    /**
     * Constructor.
     *
     * @param mixed  $value The numeric value to convert to words.
     * @param string $type  The type of the value ('integer' or 'double').
     */
    public function __construct($value, string $type)
    {
        $this->value = $value;
        $this->type = $type;
        $this->locale = config('spell-number.default.lang') ?? Langs::getLocaleLaravel();
        $this->currency = config('spell-number.default.currency') ?? 'dollars';
        $this->fraction = config('spell-number.default.fraction') ?? 'cents';
    }

    /**
     * Set the locale for the conversion.
     *
     * @param string $locale The locale to use for the conversion.
     *
     * @throws SpellNumberExceptions If the provided locale is not valid.
     *
     * @return SpellNumber The SpellNumber instance with the updated locale.
     */
    public function locale(string $locale, ?bool $specific_locale = null)
    {
        $valueConfig = config('spell-number.default.specific_locale');

        $specific_locale = $specific_locale ?? $valueConfig ?? false;

        if ($specific_locale === false) {
            if (!Utilities::isValidLocale($locale)) {
                throw SpellNumberExceptions::create('The provided value is not valid. To view the available options, you can use the SpellNumber::getAvailableLocales() method, or you can pass the SpellNumber::SPECIFIC_LOCALE constant as the second parameter to enable specific or customized usage.');
            }
        }

        $this->locale = $locale;

        return $this;
    }

    /**
     * Set the currency for the conversion.
     *
     * @param string $currency The currency to use for the conversion.
     *
     * @return SpellNumber The SpellNumber instance with the updated currency.
     */
    public function currency(string $currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Set the fraction for the conversion.
     *
     * @param string $fraction The fraction to use for the conversion.
     *
     * @return SpellNumber The SpellNumber instance with the updated fraction.
     */
    public function fraction(string $fraction)
    {
        $this->fraction = $fraction;

        return $this;
    }

    /**
     * Convert the numeric value to words.
     *
     * @return string The textual representation of the numeric value.
     */
    public function toLetters()
    {
        $callback = config('spell-number.callback_output');

        if (!empty($callback) && is_callable($callback)) {
            $words = ($this->type == 'integer') ? Str::title($this->integerToLetters()) : Str::title($this->doubleToLetters());

            return $callback(new DataResponse([
                'method'   => 'toLetters',
                'type'     => $this->type,
                'value'    => $this->value,
                'words'    => $words,
                'lang'     => Utilities::extractPrimaryLocale($this->locale),
                'locale'   => $this->locale,
                'currency' => null,
                'fraction' => null,
            ]));
        }

        return ($this->type == 'integer') ? Str::title($this->integerToLetters()) : Str::title($this->doubleToLetters());
    }

    /**
     * Convert the numeric value to a money representation.
     *
     * @return string The textual representation of the money value.
     */
    public function toMoney()
    {
        $callback = config('spell-number.callback_output');

        if (!empty($callback) && is_callable($callback)) {
            $words = ($this->type == 'integer') ? Str::title($this->integerToMoney()) : Str::title($this->doubleToMoney());

            return $callback(new DataResponse([
                'method'   => 'toMoney',
                'type'     => $this->type,
                'value'    => $this->value,
                'words'    => $words,
                'lang'     => Utilities::extractPrimaryLocale($this->locale),
                'locale'   => $this->locale,
                'currency' => $this->currency,
                'fraction' => $this->fraction,
            ]));
        }

        return ($this->type == 'integer') ? Str::title($this->integerToMoney()) : Str::title($this->doubleToMoney());
    }

    /**
     * Convert the numeric value to ordinal representation.
     * 
     * @return string The textual representation of the ordinal value.
     */
    public function toOrdinal(?string $attr = null)
    {
        $valueConfig = config('spell-number.default.ordinal_output');

        $attr = Utilities::textOrdinalMode($attr ?? $valueConfig);

        $callback = config('spell-number.callback_output');

        if (!empty($callback) && is_callable($callback)) {
            $words = Str::title($this->integerToOrdinal($attr));

            return $callback(new DataResponse([
                'method'   => 'toOrdinal',
                'type'     => $this->type,
                'value'    => $this->value,
                'words'    => $words,
                'lang'     => Utilities::extractPrimaryLocale($this->locale),
                'locale'   => $this->locale,
                'mode'     => Utilities::textOrdinalModeHuman($attr),
            ]));
        }

        return Str::title($this->integerToOrdinal($attr));
    }

    /**
     * Convert the integer numeric value to its ordinal textual representation.
     *
     * @return string The textual representation of the ordinal value.
     */
    private function integerToOrdinal($attr)
    {
        if ($this->type == 'double') {
            throw SpellNumberExceptions::create("To convert to ordinal numbers, an integer value is required as input");
        }

        $formatter = NumberFormatterWrapper::format($this->value, $this->locale, true, $attr);

        return $formatter;
    }

    /**
     * Convert the integer numeric value to its textual representation.
     *
     * @return string The textual representation of the integer numeric value.
     */
    private function integerToLetters()
    {
        $formatter = NumberFormatterWrapper::format($this->value, $this->locale);

        return $formatter;
    }

    /**
     * Convert the double numeric value to its textual representation.
     *
     * @return string The textual representation of the double numeric value.
     */
    private function doubleToLetters()
    {
        $parts = explode('.', $this->value);

        if (!array_key_exists(1, $parts)) {
            return $this->integerToLetters();
        }

        $parts[1] = Utilities::decimal($parts[1]);

        $letters1 = NumberFormatterWrapper::format($parts[0], $this->locale);
        $letters2 = NumberFormatterWrapper::format($parts[1], $this->locale);

        return sprintf('%s %s %s', $letters1, Utilities::connector($this->locale), $letters2);
    }

    /**
     * Convert the integer numeric value to its money representation.
     *
     * @return string The money representation of the integer numeric value.
     */
    private function integerToMoney()
    {
        $letters = NumberFormatterWrapper::format($this->value, $this->locale);
        $letters = Words::locale($letters, $this->locale, $this->currency);

        return $letters;
    }

    /**
     * Convert the double numeric value to its money representation.
     *
     * @return string The money representation of the double numeric value.
     */
    private function doubleToMoney()
    {
        $parts = explode('.', $this->value);

        if (!array_key_exists(1, $parts)) {
            return $this->integerToMoney();
        }

        $parts[1] = Utilities::decimal($parts[1]);

        $letters1 = NumberFormatterWrapper::format($parts[0], $this->locale);
        $letters1 = Words::locale($letters1, $this->locale, $this->currency);

        $letters2 = NumberFormatterWrapper::format($parts[1], $this->locale);
        $letters2 = Words::locale($letters2, $this->locale, $this->fraction);

        return Str::title($letters1.' '.Utilities::connector($this->locale).' '.$letters2);
    }
}
