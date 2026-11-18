<?php

declare(strict_types=1);

namespace Rmunate\Utilities;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Traits\Macroable;
use IntlException;
use Locale;
use ResourceBundle;
use Rmunate\Utilities\Callback\DataResponse;
use Rmunate\Utilities\Exceptions\SpellNumberExceptions;
use Rmunate\Utilities\Langs\Langs;
use Rmunate\Utilities\Miscellaneous\Words;
use Rmunate\Utilities\Validator\SpellNumberValidator;
use Rmunate\Utilities\Wrappers\NumberFormatterWrapper;

/**
 * Convert numbers into localized cardinal, monetary, or ordinal words.
 */
class SpellNumber
{
    use Macroable;

    /** Opt in to regional locales and additional ICU languages. */
    public const SPECIFIC_LOCALE = true;

    /** Request the locale's default ordinal spellout rule. */
    public const ORDINAL_DEFAULT = '%spellout-ordinal';

    /** Request the locale's masculine ordinal spellout rule. */
    public const ORDINAL_MALE = '%spellout-ordinal-masculine';

    /** Request the locale's feminine ordinal spellout rule. */
    public const ORDINAL_FEMALE = '%spellout-ordinal-feminine';

    /** Select letter conversion from a macro. */
    public const TO_LETTERS = 'TO_LETTERS';

    /** Select money conversion from a macro. */
    public const TO_MONEY = 'TO_MONEY';

    /** Select ordinal conversion from a macro. */
    public const TO_ORDINAL = 'TO_ORDINAL';

    /** @var array{whole: int, fraction: ?int, negativeZero: bool, type: 'integer'|'double'} */
    private array $number;

    /** The originally supplied value, made available to output callbacks. */
    private int|float|string $value;

    /** The ICU locale identifier for this conversion. */
    protected string $locale;

    /** The label for the whole unit of currency. */
    protected string $currency;

    /** The label for the fractional unit of currency. */
    protected string $fraction;

    /**
     * Prepare a number and read the default locale and currency from Laravel if available.
     *
     * @param mixed  $value A PHP integer, float, or decimal string.
     * @param string $type  The input mode: 'mixed', 'integer', or 'double'.
     *
     * @throws SpellNumberExceptions When the value, type, or default locale is invalid.
     */
    public function __construct(mixed $value, string $type = 'mixed')
    {
        $this->number = SpellNumberValidator::parse($value, $type);
        $this->value = $value;

        $locale = self::config('spell-number.default.lang') ?? self::config('spell-number.default.locale');

        if ($locale === null) {
            $language = Langs::primary(self::config('app.locale', 'en'));
            $this->locale = isset(Langs::LOCALES_AVAILABLE[$language]) ? $language : 'en';
        } elseif (is_string($locale)) {
            $this->locale($locale);
        } else {
            throw SpellNumberExceptions::create('The configured default locale must be a string or null.');
        }

        $this->currency = self::config('spell-number.default.currency') ?? 'dollars';
        $this->fraction = self::config('spell-number.default.fraction') ?? 'cents';
    }

    /**
     * Create a conversion from an integer, float, or plain decimal string.
     *
     * @throws SpellNumberExceptions When the input is invalid or out of range.
     */
    public static function value(mixed $value): static
    {
        return new static($value, 'mixed');
    }

    /**
     * Create a conversion from a native PHP integer.
     *
     * @throws SpellNumberExceptions When the input is not a PHP int.
     */
    public static function integer(mixed $value): static
    {
        return new static($value, 'integer');
    }

    /**
     * Create a conversion from a decimal string without losing the supplied precision.
     *
     * @throws SpellNumberExceptions When the input is not a plain decimal string.
     */
    public static function float(mixed $value): static
    {
        if (!is_string($value)) {
            throw SpellNumberExceptions::create('The float() factory requires a decimal string. Use value() for a native float.');
        }

        return new static($value, 'double');
    }

    /**
     * List ICU resource locales; not all of them include spellout rules.
     *
     * @throws SpellNumberExceptions When the installed ICU locales cannot be read.
     *
     * @return list<string>
     */
    public static function getAllLocales(): array
    {
        try {
            $locales = ResourceBundle::getLocales('');
        } catch (IntlException $exception) {
            throw SpellNumberExceptions::create('The installed ICU locales could not be read.', 0, $exception);
        }

        if ($locales === false) {
            throw SpellNumberExceptions::create('The installed ICU locales could not be read.');
        }

        return $locales;
    }

    /**
     * List the primary locale codes with package-provided formatting defaults.
     *
     * @return list<string>
     */
    public static function getAvailableLocales(): array
    {
        return array_keys(self::getAvailableLanguages());
    }

    /**
     * List preset languages by their primary locale codes.
     *
     * @return array<string, string>
     */
    public static function getAvailableLanguages(): array
    {
        return Langs::LOCALES_AVAILABLE;
    }

    /**
     * Select a preset language or opt in to an installed regional or additional ICU locale.
     *
     * @throws SpellNumberExceptions When the locale is invalid or requires specific locale mode.
     */
    public function locale(string $locale, ?bool $specific_locale = null): static
    {
        $specific_locale ??= self::config('spell-number.default.specific_locale') === true;

        try {
            $canonical = trim($locale) === '' ? null : Locale::canonicalize($locale);
        } catch (IntlException $exception) {
            throw SpellNumberExceptions::create("Invalid locale '{$locale}'.", 0, $exception);
        }

        if ($canonical === null || (
            !isset(Langs::LOCALES_AVAILABLE[$canonical])
            && (!$specific_locale || !in_array($canonical, self::getAllLocales(), true))
        )) {
            throw SpellNumberExceptions::create("Unsupported locale '{$locale}'. Use getAvailableLocales() for presets or enable SPECIFIC_LOCALE for an installed ICU locale.");
        }

        $this->locale = $locale;

        return $this;
    }

    /**
     * Set the label for the whole unit of currency.
     */
    public function currency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Set the label for the fractional unit of currency.
     */
    public function fraction(string $fraction): static
    {
        $this->fraction = $fraction;

        return $this;
    }

    /**
     * Spell out the number, including any fractional component.
     *
     * @return mixed The lowercase words, or the configured callback's result.
     */
    public function toLetters(): mixed
    {
        return $this->output('toLetters', $this->cardinal());
    }

    /**
     * Spell out the number using the configured currency and fraction labels.
     *
     * @return mixed The lowercase monetary words, or the configured callback's result.
     */
    public function toMoney(): mixed
    {
        return $this->output('toMoney', $this->cardinal(money: true));
    }

    /**
     * Spell out an integer ordinal in the requested default, masculine, or feminine mode.
     *
     * @throws SpellNumberExceptions When the value, mode, or ICU rule is unsupported.
     *
     * @return mixed The lowercase ordinal words, or the configured callback's result.
     */
    public function toOrdinal(?string $attr = null): mixed
    {
        if ($this->number['type'] !== 'integer') {
            throw SpellNumberExceptions::create('To convert to ordinal words, provide an integer.');
        }

        $mode = $attr ?? self::config('spell-number.default.ordinal_output') ?? 'default';
        [$rule, $mode] = match ($mode) {
            'default', 'ordinal', self::ORDINAL_DEFAULT => [self::ORDINAL_DEFAULT, 'default'],
            'male', 'masculine', 'ordinal-masculine', self::ORDINAL_MALE => [self::ORDINAL_MALE, 'male'],
            'female', 'feminine', 'ordinal-feminine', self::ORDINAL_FEMALE => [self::ORDINAL_FEMALE, 'female'],
            default => throw SpellNumberExceptions::create('The ordinal mode must be default, male, or female.'),
        };

        $formatter = new NumberFormatterWrapper($this->locale);

        return $this->output('toOrdinal', $formatter->ordinal($this->number['whole'], $rule), $mode);
    }

    /**
     * Spell the whole and optional fractional components, with or without currency labels.
     */
    private function cardinal(bool $money = false): string
    {
        $formatter = new NumberFormatterWrapper($this->locale);
        $language = Langs::primary($this->locale);
        $whole = $this->number['whole'];
        $words = $formatter->cardinal($whole, $this->number['negativeZero']);

        if ($money) {
            $words = Words::moneyPart($words, $whole, $this->currency, $language);
        }

        $fraction = $this->number['fraction'];

        if ($fraction === null) {
            return $words;
        }

        $fractionWords = $formatter->cardinal($fraction);

        if ($money) {
            $fractionWords = Words::moneyPart($fractionWords, $fraction, $this->fraction, $language);
        }

        $connector = Langs::LOCALES_CONNECTORS[$language] ?? null;
        $separator = $connector === null ? $formatter->decimalSeparator() : ' '.$connector;

        return $words.$separator.' '.$fractionWords;
    }

    /**
     * Apply the configured replacements and pass the final words and metadata to the callback.
     */
    private function output(string $method, string $words, ?string $mode = null): mixed
    {
        $language = Langs::primary($this->locale);
        $words = Words::replaceFromConfig($words, self::config("spell-number.replacements.{$language}") ?? []);
        $callback = self::config('spell-number.callback_output');

        if ($callback === null) {
            return $words;
        }

        if (!is_callable($callback)) {
            throw SpellNumberExceptions::create('The configured output callback must be callable or null.');
        }

        return $callback(new DataResponse([
            'method'   => $method,
            'type'     => $this->number['type'],
            'value'    => $this->value,
            'words'    => $words,
            'lang'     => $language,
            'locale'   => $this->locale,
            'mode'     => $mode,
            'currency' => $method === 'toMoney' ? $this->currency : null,
            'fraction' => $method === 'toMoney' ? $this->fraction : null,
        ]));
    }

    /**
     * Read Laravel configuration if the application has bootstrapped its repository.
     */
    private static function config(string $key, mixed $default = null): mixed
    {
        $app = Facade::getFacadeApplication();

        return $app !== null && $app->bound('config') ? $app->make('config')->get($key, $default) : $default;
    }

    /**
     * Dispatch a conversion from a bound SpellNumber macro.
     *
     * @throws SpellNumberExceptions When the macro requests an unknown conversion.
     */
    private function spell(string $method, ?string $modeOrdinal = null): mixed
    {
        return match ($method) {
            self::TO_LETTERS  => $this->toLetters(),
            self::TO_MONEY    => $this->toMoney(),
            self::TO_ORDINAL  => $this->toOrdinal($modeOrdinal),
            default           => throw SpellNumberExceptions::create('The macro must select TO_LETTERS, TO_MONEY, or TO_ORDINAL.'),
        };
    }
}
