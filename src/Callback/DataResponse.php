<?php

namespace Rmunate\Utilities\Callback;

class DataResponse
{
    protected $method;
    protected $type;
    protected $lang;
    protected $locale;
    protected $mode;
    protected $currency;
    protected $fraction;
    public $value;
    public $words;

    /**
     * Constructor for DataResponse.
     *
     * @param array $data An associative array containing response data.
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

    /**
     * Get the method associated with the response.
     *
     * @return string The method name.
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Get the type associated with the response.
     *
     * @return string The response type.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the value associated with the response.
     *
     * @return mixed The response value.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the words associated with the response.
     *
     * @return string The response words.
     */
    public function getWords()
    {
        return $this->words;
    }

    /**
     * Get the language associated with the response.
     *
     * @return string The response language.
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Get the locale associated with the response.
     *
     * @return string The response locale.
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Get the currency associated with the response.
     *
     * @return string The response currency.
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Get the fraction associated with the response.
     *
     * @return string The response fraction.
     */
    public function getFraction()
    {
        return $this->fraction;
    }
}
