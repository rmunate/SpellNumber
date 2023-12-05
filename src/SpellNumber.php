<?php

namespace Rmunate\Utilities;

use Closure;
use NumberFormatter;
use IntlDateFormatter;
use Rmunate\Utilities\Langs\Langs;
use Illuminate\Support\Facades\App;
use Rmunate\Utilities\Traits\Spell;
use Rmunate\Utilities\Traits\Constants;
use Rmunate\Utilities\Traits\Processor;
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
    use Constants;
    use Processor;
    use Macroable;
    use Spell;
  
    private $type;
    private $value;
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
    public function locale(string $locale, bool $specific_locale = true)
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
        $this->connector = trim($connector);

        return $this;
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
                'method'    =>  'toLetters',
                'type'      =>  $this->type,
                'value'     =>  $this->value,
                'locale'    =>  $this->locale,
                'connector' =>  $this->connector,
                'replaces'  =>  $this->replacements,
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
                'method'    =>  'toOrdinal',
                'type'      =>  $this->type,
                'value'     =>  $this->value,
                'locale'    =>  $this->locale,
                'replaces'  =>  $this->replacements,
                'output'     =>  $words,
                'lang'      =>  Utilities::extractPrimaryLocale($this->locale),
                'mode'      =>  Utilities::textOrdinalModeHuman($attr),
                'spell'     =>  function(string $method, ?string $modeOrdinal = null){
                                    return $this-> spell($method, $modeOrdinal);
                                }
            ]));
        }

        return $words;
    }




    

    

    

    
    
    




























    /**
     * Convert the integer numeric value to its textual representation.
     *
     * @return string The textual representation of the integer numeric value.
     */
    private function integerToLetters()
    {
        // Text format
        $formatter = NumberFormatterWrapper::format($this->value, $this->locale);

        // Replacements from the same package
        $formatter = Words::replaceLocale($formatter, $this->locale, self::TO_LETTERS);

        // Replacements from configuration
        $formatter = Words::replaceFromConfig($formatter, $this->locale);

        // Apply user-supplied replacements
        $formatter = Words::replaceCustom($formatter, $this->replacements);

        return $formatter;
    }

    /**
     * Convert the double numeric value to its textual representation.
     *
     * @return string The textual representation of the double numeric value.
     */
    private function doubleToLetters()
    {
        // Ensure the second value after the decimal point is not 0
        $parts = explode('.', $this->value);
        if (!array_key_exists(1, $parts)) {
            return $this->integerToLetters();
        }

        // Adjust the decimal value
        $parts[1] = Utilities::decimal($parts[1]);

        // Translate the values separately
        $letters1 = NumberFormatterWrapper::format($parts[0], $this->locale);
        $letters2 = NumberFormatterWrapper::format($parts[1], $this->locale);

        // Define the connector for the output
        $output = Utilities::connector($this->connector, $this->locale, $letters1, $letters2);

        // Replacements from the same package
        $output = Words::replaceLocale($output, $this->locale, self::TO_LETTERS);

        // Replacements from the configuration
        $output = Words::replaceFromConfig($output, $this->locale);

        // User-supplied replacements
        $output = Words::replaceCustom($output, $this->replacements);

        return $output;
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
        $letters = Words::replaceLocale($letters, $this->locale, self::TO_MONEY);

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
        $output = Words::replaceLocale($output, $this->locale, self::TO_MONEY);

        // Replacements from the configuration
        $output = Words::replaceFromConfig($output, $this->locale);

        // User-supplied replacements
        $output = Words::replaceCustom($output, $this->replacements);

        return $output;
    }

    






































    /**
     * Converts spelled-out numbers to numeric values.
     *
     * @param Closure|null $callback An optional callback function to process the result.
     *
     * @return mixed The numeric value or the result of the callback.
     *
     * @throws SpellNumberException If the provided value cannot be parsed.
     */
    public function toNumbers(Closure $callback = null)
    {
        if (!in_array($this->type, ["text"])) {
            throw SpellNumberExceptions::create("The 'toNumbers' method requires the class initializer to be 'text()'");
        }

        // Use NumberFormatter to parse the spelled-out number
        $formatter = new NumberFormatter($this->locale, NumberFormatter::SPELLOUT);
        $numericValue = $formatter->parse($this->value);

        // Check if parsing was successful
        if (empty($numericValue) || $numericValue === false) {
            // Throw an exception with an improved and English error message
            throw SpellNumberExceptions::create("The provided value could not be read in '{$this->locale}', please check if it is correctly written.");
        }

        // If a callback is provided and is callable, execute it
        if (!empty($callback) && is_callable($callback)) {
            // Return the result of the callback, passing a DataResponse object
            return $callback(new SpellNumberCallable([
                'spell' => function (string $method, ?string $modeOrdinal = null) {
                    return $this->spell($method, $modeOrdinal);
                },
                'output' => $this->value,
                'value' => $numericValue,
                'locale' => $this->locale,
            ]));
        }

        // If no callback, return the numeric value
        return $numericValue;
    }

    /**
     * Converts a decimal number to a Roman numeral.
     *
     * @param Closure|null $callback An optional callback function to process the result.
     *
     * @return mixed The Roman numeral or the result of the callback.
     */
    public function toRomanNumeral(Closure $callback = null)
    {
        if (!in_array($this->type, ["integer"])) {
            throw SpellNumberExceptions::create("The 'toRomanNumeral' method requires the supplied value to be of integer type");
        }

        $formatter = new NumberFormatter('@numbers=roman', NumberFormatter::DECIMAL);
        $result = $formatter->format($this->value);

        // Replacements from the configuration
        $words = Words::replaceFromConfig($result, $this->locale);

        // User-supplied replacements
        $words = Words::replaceCustom($words, $this->replacements);
        
        // If a callback is provided and is callable, execute it
        if (!empty($callback) && is_callable($callback)) {
            // Return the result of the callback, passing a DataResponse object
            return $callback(new SpellNumberCallable([
                'spell' => function (string $method, ?string $modeOrdinal = null) {
                    return $this->spell($method, $modeOrdinal);
                },
                'output' => $words,
                'value' => $this->value,
                'locale' => '@numbers=roman',
                'replacements' => $this->replacements,
            ]));
        }

        // If no callback, return the numeric value
        return $words;
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
        if (!in_array($this->type, ["integer", "double"])) {
            throw SpellNumberExceptions::create("The 'toSummary' method requires the supplied value to be of integer or float type");
        }

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

        // Replacements from the configuration
        $words = Words::replaceFromConfig($result, $this->locale);

        // User-supplied replacements
        $words = Words::replaceCustom($words, $this->replacements);
        
        // If a callback is provided and is callable, execute it
        if (!empty($callback) && is_callable($callback)) {

            // Return the result of the callback, passing a DataResponse object
            return $callback(new SpellNumberCallable([
                'spell' => function (string $method, ?string $modeOrdinal = null) {
                    return $this->spell($method, $modeOrdinal);
                },
                'output' => $words,
                'value' => $this->value,
                'precision' => $precision,
                'locale' => $this->locale,
                'replacements' => $this->replacements,
            ]));
        }

        // If no callback, return the numeric value
        return $words;
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
        if (!in_array($this->type, ["integer", "double"])) {
            throw SpellNumberExceptions::create("The 'toCurrency' method requires the supplied value to be of integer or float type");
        }

        $formatter = new NumberFormatter($this->locale, NumberFormatter::CURRENCY);
        $result = $formatter->formatCurrency($this->value, $currency);

        // Replacements from the configuration
        $words = Words::replaceFromConfig($result, $this->locale);

        // User-supplied replacements
        $words = Words::replaceCustom($words, $this->replacements);
        
        // If a callback is provided and is callable, execute it
        if (!empty($callback) && is_callable($callback)) {

            // Return the result of the callback, passing a DataResponse object
            return $callback(new SpellNumberCallable([
                'spell' => function (string $method, ?string $modeOrdinal = null) {
                    return $this->spell($method, $modeOrdinal);
                },
                'output' => $words,
                'value' => $this->value,
                'currency' => $currency,
                'locale' => $this->locale,
                'replacements' => $this->replacements,
            ]));
        }

        // If no callback, return the numeric value
        return $words;
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
    public function inWords($pattern = 'dd MMMM yyyy', Closure $callback = null)
    {
        if (!in_array($this->type, ["date"])) {
            throw SpellNumberExceptions::create("The 'inWords' method requiere que el inicializador de la clase sea 'date('yyyy-mm-dd')'");
        }

        $formatter = new IntlDateFormatter(
            $this->locale,
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            null,
            null,
            $pattern
        );
    
        $result = $formatter->format(strtotime($this->value));

        // Replacements from the configuration
        $words = Words::replaceFromConfig($result, $this->locale);

        // User-supplied replacements
        $words = Words::replaceCustom($words, $this->replacements);
        
        // If a callback is provided and is callable, execute it
        if (!empty($callback) && is_callable($callback)) {

            // Return the result of the callback, passing a DataResponse object
            return $callback(new SpellNumberCallable([
                'spell' => function (string $method, ?string $modeOrdinal = null) {
                    return $this->spell($method, $modeOrdinal);
                },
                'output' => $words,
                'value' => $this->value,
                'locale' => $this->locale,
                'pattern' => $pattern,
                'replacements' => $this->replacements,
            ]));
        }

        // If no callback, return the numeric value
        return $words;
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
        if (!in_array($this->type, ["integer", "double"])) {
            throw SpellNumberExceptions::create("The 'toPercent' method requires the supplied value to be of integer or float type");
        }

        $formatter = new NumberFormatter($this->locale, NumberFormatter::PERCENT);
        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, $digits);
        $words = $formatter->format($this->value);

        // If a callback is provided and is callable, execute it
        if (!empty($callback) && is_callable($callback)) {
            // Return the result of the callback, passing a DataResponse object
            return $callback(new SpellNumberCallable([
                'spell'     => function (string $method, ?string $modeOrdinal = null) {
                    return $this->spell($method, $modeOrdinal);
                },
                'output'     => $words,
                'value'     => $this->value,
                'digits'    => $this->digits,
                'locale'    => $this->locale,
            ]));
        }

        // If no callback, return the numeric value
        return $words;
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
        if (!in_array($this->type, ["integer", "double"])) {
            throw SpellNumberExceptions::create("The 'toScientific' method requires the supplied value to be of integer or float type");
        }

        $formatter = new NumberFormatter($this->locale, NumberFormatter::SCIENTIFIC);
        $words = $formatter->format($this->value);

        // If a callback is provided and is callable, execute it
        if (!empty($callback) && is_callable($callback)) {
            // Return the result of the callback, passing a DataResponse object
            return $callback(new SpellNumberCallable([
                'spell' => function (string $method, ?string $modeOrdinal = null) {
                    return $this->spell($method, $modeOrdinal);
                },
                'output' => $words,
                'value' => $this->value,
                'locale' => $this->locale,
            ]));
        }

        // If no callback, return the numeric value
        return $words;
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
    public function toClock(Closure $callback = null){

        if (!in_array($this->type, ["integer", "double"])) {
            throw SpellNumberExceptions::create("The 'toClock' method requires the supplied value to be of integer or float type");
        }

        $formatter = new NumberFormatter($this->locale, NumberFormatter::DURATION);
        $words = $formatter->format($this->value);
        
        // If a callback is provided and is callable, execute it
        if (!empty($callback) && is_callable($callback)) {
            // Return the result of the callback, passing a DataResponse object
            return $callback(new SpellNumberCallable([
                'spell' => function (string $method, ?string $modeOrdinal = null) {
                    return $this->spell($method, $modeOrdinal);
                },
                'output' => $words,
                'value' => $this->value,
                'locale' => $this->locale,
            ]));
        }

        // If no callback, return the numeric value
        return $words;
    }
}
