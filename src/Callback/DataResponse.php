<?php

declare(strict_types=1);

namespace Rmunate\Utilities\Callback;

/**
 * The formatted words and conversion context received by an output callback.
 */
class DataResponse
{
    /** The conversion method name. */
    protected ?string $method;

    /** The input mode: 'integer' or 'double'. */
    protected ?string $type;

    /** The primary language subtag. */
    protected ?string $lang;

    /** The full locale requested for this conversion. */
    protected ?string $locale;

    /** The requested ordinal mode, when applicable. */
    protected ?string $mode;

    /** The configured whole currency label, when applicable. */
    protected ?string $currency;

    /** The configured fractional currency label, when applicable. */
    protected ?string $fraction;

    /** The original input supplied to the conversion. */
    public mixed $value;

    /** The words after built-in and configured replacements. */
    public ?string $words;

    /**
     * Create the payload from conversion metadata.
     *
     * @param array{method?: ?string, type?: ?string, lang?: ?string, locale?: ?string, mode?: ?string, currency?: ?string, fraction?: ?string, value?: mixed, words?: ?string} $data
     */
    public function __construct(array $data)
    {
        $this->method = $data['method'] ?? null;
        $this->type = $data['type'] ?? null;
        $this->value = $data['value'] ?? null;
        $this->words = $data['words'] ?? null;
        $this->lang = $data['lang'] ?? null;
        $this->locale = $data['locale'] ?? null;
        $this->mode = $data['mode'] ?? null;
        $this->currency = $data['currency'] ?? null;
        $this->fraction = $data['fraction'] ?? null;
    }

    /** Get the conversion method name. */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /** Get the input mode: 'integer' or 'double'. */
    public function getType(): ?string
    {
        return $this->type;
    }

    /** Get the supplied number without any normalization. */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /** Get the words after built-in and configured replacements. */
    public function getWords(): ?string
    {
        return $this->words;
    }

    /** Get the primary language subtag, such as 'es'. */
    public function getLang(): ?string
    {
        return $this->lang;
    }

    /** Get the requested locale, such as 'es_MX'. */
    public function getLocale(): ?string
    {
        return $this->locale;
    }

    /** Get the requested ordinal mode, or null for non-ordinal conversions. */
    public function getMode(): ?string
    {
        return $this->mode;
    }

    /** Get the configured currency label, or null for non-monetary conversions. */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /** Get the configured fraction label, or null for non-monetary conversions. */
    public function getFraction(): ?string
    {
        return $this->fraction;
    }
}
