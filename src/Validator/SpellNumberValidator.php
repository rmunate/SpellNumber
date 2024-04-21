<?php

namespace Rmunate\Utilities\Validator;

use Rmunate\Utilities\Exceptions\SpellNumberExceptions;
use Rmunate\Utilities\Miscellaneous\Utilities;
use Rmunate\Utilities\Bases\BaseSpellNumberValidator;

class SpellNumberValidator extends BaseSpellNumberValidator
{
    /**
     * The value to validate.
     *
     * @var mixed
     */
    private $value;

    /**
     * The validation response.
     *
     * @var mixed
     */
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
        // Assign the value to the property value.
        $this->value = $value;

        // Validate if the intl extension is loaded.
        if (!Utilities::validateExtension('intl')) {
            throw SpellNumberExceptions::create(
                'The INTL extension is not loaded in the environment; please check your php.ini.'
            );
        }

        // Validate that it is not in scientific notation.
        if (Utilities::isScientificConnotation($this->value)) {
            throw SpellNumberExceptions::create(
                'The supplied value is in scientific notation or exceeds the allowed limit.'
            );
        }

        // Execute the appropriate validation based on the type.
        match ($type) {
            'mixed'   => $this->mixed(),
            'integer' => $this->integer(),
            'double'  => $this->float(),
            'text'    => $this->text(),
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
        if (!Utilities::isValidNumber($this->value)) {
            throw SpellNumberExceptions::create(
                'The supplied value is not numeric; it may be text or in scientific notation.'
            );
        }

        if (!Utilities::isNotExceedMax($this->value)) {
            throw SpellNumberExceptions::create(
                'The supplied value is too large to process with the current PHP version.'
            );
        }

        $this->response = Utilities::isValidInteger($this->value) ? 'integer' : 'double';

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
        if (!Utilities::isValidInteger($this->value)) {
            throw SpellNumberExceptions::create(
                'The supplied value is not an integer; consider using the value() method if doubles are also used.'
            );
        }

        if (!Utilities::isNotExceedMax($this->value)) {
            throw SpellNumberExceptions::create(
                'The supplied value is too large to process with the current PHP version.'
            );
        }

        $this->response = true;

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
        if (!Utilities::isValidString($this->value)) {
            throw SpellNumberExceptions::create(
                'The expected value should be a string since the ideal is not to approximate decimal values.'
            );
        }

        if (!Utilities::isNotExceedMax($this->value)) {
            throw SpellNumberExceptions::create(
                'The supplied value is too large to process with the current PHP version.'
            );
        }

        $this->response = true;

        return $this;
    }

    /**
     * Validate when the type is "text".
     *
     * @throws SpellNumberExceptions
     *
     * @return $this
     */
    public function text()
    {
        if (!is_string($this->value)) {
            throw SpellNumberExceptions::create(
                'The supplied value is not a string; a valid alphabetic value is expected for converting to numbers.'
            );
        }

        $this->response = true;

        return $this;
    }

    /**
     * Validate if the given value is a date in the format "YYYY-MM-DD".
     *
     * @param string $date The date string to validate.
     *
     * @throws InvalidArgumentException If the date is not in the expected format.
     */
    function date(string $date)
    {
        $pattern = '/^\d{4}-\d{2}-\d{2}$/';

        if (!preg_match($pattern, $date)) {
            throw SpellNumberExceptions::create(
                'Invalid date format. Expected format: "YYYY-MM-DD".'
            );
        }

        $this->response = true;

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
