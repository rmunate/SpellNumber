<?php

namespace Rmunate\Utilities\Traits;

trait Output
{
    /**
     * Sanitize a value by removing non-readable characters.
     *
     * @param mixed $value The value to sanitize.
     *
     * @return mixed The sanitized value.
     */
    public function output($value)
    {
        // Replacements for non-readable characters
        $characters = [
            "\u{AD}",
            "\u{200B}"
        ];

        // Apply replacements
        $output = str_replace($characters, '', $value);

        return $output;
    }
}
