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
        // Populate object properties with data from the array.
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
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
