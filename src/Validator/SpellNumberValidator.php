<?php

namespace Rmunate\Utilities\Validator;

use Rmunate\Utilities\Bases\BaseSpellNumberValidator;
use Rmunate\Utilities\Validator\Traits\CommonValidate;

final class SpellNumberValidator extends BaseSpellNumberValidator
{
    /* Traits */
    use CommonValidate;

    /* Validator Response */
    private $value;
    private $response;

    /**
     * Create a new instance of the SpellNumberValidator.
     *
     * @param string $type  The type of data to validate (e.g., "mixed", "integer", "float").
     * @param mixed  $value The value to validate.
     *
     * @throws SpellNumberExceptions
     */
    public function __construct(string $type, $value)
    {
        // Assign the value to validate.
        $this->value = $value;

        // Check if the intl extension is installed.
        $this->validateExtension();

        // Validate that it is not a scientific notation.
        $this->validateScientificConnotation();

        // Execute the appropriate validation based on the type.
        match ($type) {
            'mixed'   => $this->mixed(),
            'integer' => $this->integer(),
            'double'  => $this->float()
        };
    }

    /**
     * Validate when the type is "mixed".
     *
     * @throws SpellNumberExceptions
     *
     * @return $this
     */
    public function mixed()
    {
        $this->validateNumeric();
        $this->validateMaximum();
        $this->response = $this->validateType();

        return $this;
    }

    /**
     * Validate when the type is "integer".
     *
     * @throws SpellNumberExceptions
     *
     * @return $this
     */
    public function integer()
    {
        $this->validateInteger();
        $this->response = $this->validateMaximum();

        return $this;
    }

    /**
     * Validate when the type is "float".
     *
     * @throws SpellNumberExceptions
     *
     * @return $this
     */
    public function float()
    {
        $this->validateString();
        $this->response = $this->validateMaximum();

        return $this;
    }

    /**
     * Get the result of the validation.
     *
     * @return mixed The result of the validation.
     */
    public function result()
    {
        return $this->response;
    }
}
