<?php

namespace Rmunate\Utilities\Callback;

class SpellNumberCallable
{
    /**
     * Constructor for SpellNumberCallable.
     *
     * @param array $data An associative array containing response data.
     */
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * Magic method to dynamically get property values.
     *
     * @param string $name The name of the property.
     *
     * @return mixed|false The property value or false if the property doesn't exist.
     */
    public function __get($name) {

        if (property_exists($this, $name)) {
            return ($name != "spell") ? $this->{$name} : false;
        }

        return false;
    }

    /**
     * Get the value associated with the response.
     *
     * @return mixed|null The response value.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the words associated with the response.
     *
     * @return string|null The response words.
     */
    public function getWords()
    {
        return $this->output;
    }

    /**
     * Get the output associated with the response.
     *
     * @return string|null The response output.
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Perform a spell-related action based on the specified method and optional ordinal mode.
     *
     * @param string      $method      The method to perform.
     * @param string|null $modeOrdinal The optional ordinal mode when using TO_ORDINAL.
     *
     * @return mixed|null The response instance.
     */
    public function spell(string $method, ?string $modeOrdinal = null)
    {
        return ($this->spell)($method, $modeOrdinal);
    }
}
