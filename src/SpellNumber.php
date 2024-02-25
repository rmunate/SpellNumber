<?php

namespace Rmunate\Utilities;

use Closure;
use NumberFormatter;
use IntlDateFormatter;
use Illuminate\Support\Facades\App;
use Rmunate\Utilities\Traits\Output;
use Rmunate\Utilities\Traits\Constants;
use Rmunate\Utilities\Traits\Processor;
use Illuminate\Support\Traits\Macroable;
use Rmunate\Utilities\Miscellaneous\Words;
use Rmunate\Utilities\Bases\BaseSpellNumber;
use Rmunate\Utilities\Miscellaneous\Utilities;
use Rmunate\Utilities\Callback\SpellNumberCallable;
use Rmunate\Utilities\Wrappers\NumberFormatterWrapper;

class SpellNumber extends BaseSpellNumber
{
    use Output;
    use Processor;
    use Macroable;
    use Constants;
































    

    

    





















    
    

    /**
     * Convert the numeric value to a money representation.
     *
     * @param Closure|null $callback Optional callback function to handle custom responses.
     * @return string The textual representation of the money value.
     */
    public function toMoney(Closure $callback = null)
    {
        $words = ($this->type == 'integer') ? $this->integerToMoney() : $this->doubleToMoney();

        if (!empty($callback) && is_callable($callback)) {

            return $callback(new SpellNumberCallable([
                'method'    =>  'toMoney',
                'type'      =>  $this->type,
                'value'     =>  $this->value,
                'locale'    =>  $this->locale,
                'connector' =>  $this->connector,
                'replaces'  =>  $this->replacements,
                'currency'  =>  $this->currency,
                'fraction'  =>  $this->fraction,
                'output'     =>  $words,
                'lang'      =>  Utilities::extractPrimaryLocale($this->locale),
                'spell'     =>  function(string $method, ?string $modeOrdinal = null){
                                    return $this->spell($method, $modeOrdinal);
                                }
            ]));
        }

        return $words;
    }

    




    

    

    

    
    
    




























    

    

    /**
     * Convert the integer numeric value to its money representation.
     *
     * @return string The money representation of the integer numeric value.
     */
    private function integerToMoney()
    {
        // Translate the value
        $letters = NumberFormatterWrapper::format($this->value, $this->locale) . ' ' . $this->currency;

        // Replacements from the same package
        $letters = Words::replaceLocale($letters, $this->locale, "TO_MONEY");

        // Replacements from the configuration
        $letters = Words::replaceFromConfig($letters, $this->locale);

        // User-supplied replacements
        $letters = Words::replaceCustom($letters, $this->replacements);

        return $letters;
    }

    /**
     * Convert the double numeric value to its money representation.
     *
     * @return string The money representation of the double numeric value.
     */
    private function doubleToMoney()
    {
        // Ensure the second value after the decimal point is not 0
        $parts = explode('.', $this->value);
        if (!array_key_exists(1, $parts)) {
            return $this->integerToMoney();
        }

        // Adjust the decimal value
        $parts[1] = Utilities::decimal($parts[1]);

        // Translate values separately
        $letters1 = NumberFormatterWrapper::format($parts[0], $this->locale) . ' ' . $this->currency;
        $letters2 = NumberFormatterWrapper::format($parts[1], $this->locale) . ' ' . $this->fraction;

        // Define the connector for the output
        $output = Utilities::connector($this->connector, $this->locale, $letters1, $letters2);

        // Replacements from the same package
        $output = Words::replaceLocale($output, $this->locale, "TO_MONEY");

        // Replacements from the configuration
        $output = Words::replaceFromConfig($output, $this->locale);

        // User-supplied replacements
        $output = Words::replaceCustom($output, $this->replacements);

        return $output;
    }

    



































    public $value;
    public $type;
    protected $locale;
    protected $currency;
    protected $fraction;
    protected $connector;
    protected $replacements;

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
        $this->locale = config('spell-number.default.locale') ?? App::getLocale();
        $this->currency = config('spell-number.default.currency') ?? 'dollars';
        $this->fraction = config('spell-number.default.fraction') ?? 'cents';
        $this->connector = null;
        $this->replacements = [];
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
    public function locale(string $locale, ...$others)
    {
        $this->locale = trim($locale);

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
        $this->currency = trim($currency);

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
        $this->fraction = trim($fraction);

        return $this;
    }

    /**
     * Set the replacements.
     * 
     * @param array $replacements
     * 
     * @return SpellNumber The SpellNumber instance with the updated replacements.
     */
    public function replacements(array $replacements)
    {
        $this->replacements = $replacements;

        return $this;
    }

    /**
     * Set the connector.
     * 
     * @param string $connector
     * 
     * @return SpellNumber The SpellNumber instance with the updated connector.
     */
    public function connector(string $connector)
    {
        $this->connector = $connector;

        return $this;
    }

    /**
     * Convert a spelled-out number to its numeric representation.
     *
     * @param Closure|null $callback An optional callback to further process the numeric value.
     *
     * @return int|bool The numeric value if successful, or false if parsing fails.
     * @throws SpellNumberExceptions Throws an exception if the type is not 'text'.
     */
    public function toNumbers(Closure $callback = null)
    {
        Utilities::includesOrException(
            $this->type,
            ["text"],
            "The toNumbers() method requires the initializing method to be text() as it is intended for converting text to numbers."
        );
        
        $formatter = new NumberFormatter($this->locale, NumberFormatter::SPELLOUT);
        $numericValue = $formatter->parse($this->value);
        
        if (empty($numericValue) || $numericValue === false) {
            return false;
        }
        
        if (!empty($callback) && is_callable($callback)) {
            return $callback(new SpellNumberCallable([
                'spell' => function (string $method, ?string $modeOrdinal = null) {
                    return $this->spell($method, $modeOrdinal);
                },
                'output' => $this->value,
                'value' => $numericValue,
                'locale' => $this->locale,
            ]));
        }
        
        return $numericValue;
    }

    /**
     * Convert an integer to a Roman numeral and perform replacements.
     *
     * @param Closure|null $callback An optional callback to further process the Roman numeral.
     *
     * @return string The Roman numeral with replacements if successful.
     * @throws SpellNumberExceptions Throws an exception if the type is not 'integer' or the value is out of an acceptable range.
     */
    public function toRomanNumeral(Closure $callback = null)
    {
        Utilities::includesOrException(
            $this->type,
            ["integer"],
            "The toRomanNumeral() method requires the supplied value to be an integer and within an acceptable range for the expected output."
        );
        
        $formatter = new NumberFormatter('@numbers=roman', NumberFormatter::DECIMAL);
        $result = $formatter->format($this->value);
        
        if (!empty($callback) && is_callable($callback)) {
            return $callback(new SpellNumberCallable([
                'spell' => function (string $method, ?string $modeOrdinal = null) {
                    return $this->spell($method, $modeOrdinal);
                },
                'output' => $this->output($words),
                'value' => $this->value,
                'locale' => '@numbers=roman',
            ]));
        }

        return $this->output($words);
    }

    /**
     * Convert a numeric value to a summarized representation with units.
     *
     * @param int      $precision   The precision of the result.
     * @param Closure  $callback    An optional callback function to process the result.
     *
     * @return mixed The summarized representation or the result of the callback.
     */
    public function toSummary(int $precision = 0, Closure $callback = null)
    {
        Utilities::includesOrException(
            $this->type,
            ["integer", "double"],
            "The toSummary() method requires the supplied value to be of integer or float type."
        );

        $units = [
            3 => 'K',
            6 => 'M',
            9 => 'B',
            12 => 'T',
            15 => 'Q',
        ];

        $number = $this->value;

        switch (true) {
            case $number === 0:
                return '0';
            case $number < 0:
                return sprintf('-%s', $this->toSummary(abs($number), $precision, $maxPrecision, $units));
            case $number >= 1e15:
                return sprintf('%s'.end($units), $this->toSummary($number / 1e15, $precision, $maxPrecision, $units));
        }

        $numberExponent = floor(log10($number));
        $displayExponent = $numberExponent - ($numberExponent % 3);
        $number /= pow(10, $displayExponent);

        $formatter = new NumberFormatter($this->locale, NumberFormatter::DECIMAL);
        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, $precision);
        $result = $formatter->format($number);
        $result = trim(sprintf('%s%s', $result, $units[$displayExponent] ?? ''));

        $words = Words::replaceFromConfig($result, $this->locale);
        $words = Words::replaceCustom($words, $this->replacements);
        
        if (!empty($callback) && is_callable($callback)) {
            return $callback(new SpellNumberCallable([
                'spell' => function (string $method, ?string $modeOrdinal = null) {
                    return $this->spell($method, $modeOrdinal);
                },
                'output' => $this->output($words),
                'value' => $this->value,
                'precision' => $precision,
                'locale' => $this->locale,
                'replacements' => $this->replacements,
            ]));
        }
        
        return $this->output($words);
    }

    /**
     * Format the numeric value as currency.
     *
     * @param string|null $currency The currency code to use for formatting.
     * @param Closure     $callback An optional callback function to process the result.
     *
     * @return mixed The formatted currency or the result of the callback.
     */
    public function toCurrency(?string $currency, Closure $callback = null)
    {
        Utilities::includesOrException(
            $this->type,
            ["integer", "double"],
            "The toCurrency() method requires the supplied value to be of integer or float type."
        );

        $formatter = new NumberFormatter($this->locale, NumberFormatter::CURRENCY);
        $words = $formatter->formatCurrency($this->value, $currency);
        
        if (!empty($callback) && is_callable($callback)) {
            return $callback(new SpellNumberCallable([
                'spell' => function (string $method, ?string $modeOrdinal = null) {
                    return $this->spell($method, $modeOrdinal);
                },
                'output' => $this->output($words),
                'value' => $this->value,
                'currency' => $currency,
                'locale' => $this->locale,
            ]));
        }

        return $this->output($words);
    }

    /**
     * Convert a date to words using the specified pattern.
     *
     * @param string $pattern The format pattern for the date. Defaults to 'dd MMMM yyyy'.
     * @param Closure|null $callback An optional callback function to process the result.
     *
     * @return mixed The date in words or the result of the callback.
     *
     * @throws SpellNumberException If the class initializer is not of type 'date('yyyy-mm-dd')'.
     */
    public function inWords(?string $pattern = null, Closure $callback = null)
    {
        Utilities::includesOrException(
            $this->type,
            ["date"],
            "The inWords() method requires that the class initializer be date()."
        );
        
        $pattern = match ($pattern) {
            "%date-format-short" => 'MMMM d, yyyy',
            "%date-format-medium" => 'EEE, MMM d, yyyy',
            "%date-format-long" => 'EEE, d MMM yyyy',
            "%date-format-full" => null,
            default => $pattern,
        };

        $formatter = new IntlDateFormatter(
            $this->locale,
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            null,
            null,
            $pattern
        );
    
        $result = $formatter->format(strtotime($this->value));

        $words = Words::replaceFromConfig($result, $this->locale);
        $words = Words::replaceCustom($words, $this->replacements);
        
        if (!empty($callback) && is_callable($callback)) {
            return $callback(new SpellNumberCallable([
                'spell' => function (string $method, ?string $modeOrdinal = null) {
                    return $this->spell($method, $modeOrdinal);
                },
                'output' => $this->output($words),
                'value' => $this->value,
                'locale' => $this->locale,
                'pattern' => $pattern,
                'replacements' => $this->replacements,
            ]));
        }

        return $this->output($words);
    }

    /**
     * Convert a numeric value to a percentage format.
     *
     * @param int $digits The number of digits to include in the percentage. Defaults to 2.
     * @param Closure|null $callback An optional callback function to process the result.
     *
     * @return mixed The numeric value formatted as a percentage or the result of the callback.
     *
     * @throws SpellNumberException If the supplied value is not of integer or float type.
     */
    public function toPercent(int $digits = 2, Closure $callback = null)
    {
        Utilities::includesOrException(
            $this->type,
            ["integer", "double"],
            "The toPercent() method requires the supplied value to be of integer or float type."
        );

        $formatter = new NumberFormatter($this->locale, NumberFormatter::PERCENT);
        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, $digits);
        $words = $formatter->format($this->value);

        if (!empty($callback) && is_callable($callback)) {
            return $callback(new SpellNumberCallable([
                'spell'     => function (string $method, ?string $modeOrdinal = null) {
                    return $this->spell($method, $modeOrdinal);
                },
                'output'     => $this->output($words),
                'value'     => $this->value,
                'digits'    => $this->digits,
                'locale'    => $this->locale,
            ]));
        }

        return $this->output($words);
    }

    /**
     * Convert a numeric value to scientific notation.
     *
     * @param Closure|null $callback An optional callback function to process the result.
     *
     * @return mixed The numeric value formatted in scientific notation or the result of the callback.
     *
     * @throws SpellNumberException If the supplied value is not of integer or float type.
     */
    public function toScientific(Closure $callback = null)
    {
        Utilities::includesOrException(
            $this->type,
            ["integer", "double"],
            "The toScientific() method requires the supplied value to be of integer or float type."
        );

        $formatter = new NumberFormatter($this->locale, NumberFormatter::SCIENTIFIC);
        $words = $formatter->format($this->value);

        if (!empty($callback) && is_callable($callback)) {
            return $callback(new SpellNumberCallable([
                'spell' => function (string $method, ?string $modeOrdinal = null) {
                    return $this->spell($method, $modeOrdinal);
                },
                'output' => $this->output($words),
                'value' => $this->value,
                'locale' => $this->locale,
            ]));
        }

        return $this->output($words);
    }

    /**
     * Convert a numeric value to clock format.
     *
     * @param Closure|null $callback An optional callback function to process the result.
     *
     * @return mixed The numeric value formatted as clock or the result of the callback.
     *
     * @throws SpellNumberException If the supplied value is not of integer or float type.
     */
    public function toClock(Closure $callback = null)
    {
        Utilities::includesOrException(
            $this->type,
            ["integer", "double"],
            "The toClock() method requires the supplied value to be of integer or float type."
        );

        $formatter = new NumberFormatter($this->locale, NumberFormatter::DURATION);
        $words = $formatter->format($this->value);
        
        if (!empty($callback) && is_callable($callback)) {
            return $callback(new SpellNumberCallable([
                'spell' => function (string $method, ?string $modeOrdinal = null) {
                    return $this->spell($method, $modeOrdinal);
                },
                'output' => $this->output($words),
                'value' => $this->value,
                'locale' => $this->locale,
            ]));
        }

        return $this->output($words);
    }

    /**
     * Convert the numeric value to ordinal representation.
     *
     * @param string|null $attr Optional attribute for ordinal representation (e.g., 'male', 'female').
     * @param Closure|null $callback Optional callback function to handle custom responses.
     * @return string The textual representation of the ordinal value.
     */
    public function toOrdinal(?string $attr = null, Closure $callback = null)
    {
        $valueConfig = config('spell-number.default.ordinal_output');

        $attr = Utilities::textOrdinalMode($attr ?? $valueConfig);

        $words = $this->integerToOrdinal($attr);

        if (!empty($callback) && is_callable($callback)) {

            return $callback(new SpellNumberCallable([
                'value'     =>  $this->value,
                'locale'    =>  $this->locale,
                'replacements' => $this->replacements,
                'output'    =>  $this->output($words),
                'mode'      =>  Utilities::textOrdinalModeHuman($attr),
                'spell'     =>  function(string $method, ?string $modeOrdinal = null){
                                    return $this-> spell($method, $modeOrdinal);
                                }
            ]));
        }

        return $this->output($words);
    }

    /**
     * Convert the numeric value to words.
     *
     * @param Closure|null $callback Optional callback function to handle custom responses.
     * @return string The textual representation of the numeric value.
     */
    public function toLetters(Closure $callback = null)
    {
        $words = ($this->type == 'integer') ? $this->integerToLetters() : $this->doubleToLetters();

        if (!empty($callback) && is_callable($callback)) {

            return $callback(new SpellNumberCallable([
                'value'     =>  $this->value,
                'locale'    =>  $this->locale,
                'connector' =>  $this->connector,
                'replacements' => $this->replacements,
                'output'     =>  $this->output($words),
                'spell'     =>  function(string $method, ?string $modeOrdinal = null){
                                    return $this->spell($method, $modeOrdinal);
                                }
            ]));
        }

        return $this->output($words);
    }
}