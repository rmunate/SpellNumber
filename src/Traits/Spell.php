<?php

namespace Rmunate\Utilities\Traits;

use Rmunate\Utilities\Exceptions\SpellNumberExceptions;

trait Spell
{
    /**
     * Main method for processing different ways of converting the output.
     *
     * @param string        $method       The method for conversion.
     * @param string|null   $config
     *
     * @return mixed
     * @throws SpellNumberExceptions Throws an exception if an invalid method is provided.
     */
    private function spell(string $method, ?string $config = null)
    {
        $messageException = "No valid way to request the output of the package processing has been provided. For information on the different ways to convert the output, refer to the SpellNumber::getConstants('General') method.";

        return match ($method) {
            '%value-to-letters'       => $this->toLetters(),
            '%value-to-money'         => $this->toMoney(),
            '%value-to-ordinal'       => $this->toOrdinal($config),
            '%value-to-clock'         => $this->toClock(),
            '%value-to-scientific'    => $this->toScientific(),
            '%value-to-percent'       => $this->toPercent($config ?? 2),
            '%value-to-currency'      => $this->toCurrency($config),
            '%value-to-summary'       => $this->toSummary($config),
            '%value-to-roman-numeral' => $this->toRomanNumeral(),
            default                   => throw SpellNumberExceptions::create($messageException),
        };
    }
}
