<?php

namespace Rmunate\Utilities\Callback;

use Rmunate\Utilities\SpellNumber;

/**
 * DataResponse
 *
 * This class represents a data response object, used for storing and accessing
 * data related to callback responses. It provides methods to retrieve various
 * properties of the response data.
 */
final class DataResponse
{
    protected $method;
    protected $type;
    protected $lang;
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
        $this->method = $data["method"];
        $this->type = $data["type"];
        $this->value = $data["value"];
        $this->words = $data["words"];
        $this->lang = $data["lang"];
        $this->currency = $data["currency"];
        $this->fraction = $data["fraction"];
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
