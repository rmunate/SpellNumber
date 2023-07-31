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
     * @param string $type The type of data to validate (e.g., "mixed", "integer", "float").
     * @param mixed $value The value to validate.
     */
    public function __construct(string $type, $value)
    {
        // Check if the intl extension is installed.
        $this->validateExtension();

        // Assign the value to validate.
        $this->value = $value;

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
     * @return $this
     */
    public function mixed()
    {
        $this->validateNumeric();
        $this->validateMaximun();
        $this->response = $this->validateType();
        return $this;
    }

    /**
     * Validate when the type is "integer".
     *
     * @return $this
     */
    public function integer()
    {
        $this->validateInteger();
        $this->response = $this->validateMaximun();
        return $this;
    }

    /**
     * Validate when the type is "float".
     *
     * @return $this
     */
    public function float()
    {
        $this->validateString();
        $this->response = $this->validateMaximun();
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
