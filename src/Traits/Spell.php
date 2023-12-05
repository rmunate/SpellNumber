<?php

namespace Rmunate\Utilities\Traits;

use Rmunate\Utilities\Exceptions\SpellNumberExceptions;

trait Spell
{
    /**
     * Perform a spell-related action based on the specified method and optional ordinal mode.
     *
     * @param string      $method      The method to perform (TO_LETTERS, TO_MONEY, or TO_ORDINAL).
     * @param string|null $modeOrdinal The optional ordinal mode when using TO_ORDINAL.
     *
     * @throws SpellNumberExceptions When the requested action is invalid.
     *
     * @return mixed The result of the specified action.
     */
    private function spell(string $method, ?string $modeOrdinal = null)
    {
        $messageException = "No valid way to request the output of the package processing has been provided. For information on the different ways to convert the output, refer to the SpellNumber::getConstants('General') method.";

        return match ($method) {
            '%value-to-letters' => $this->toLetters(),
            '%value-to-ordinal' => $this->toOrdinal($modeOrdinal),
            '%value-to-money' => $this->toMoney(),
            '%value-to-clock' => $this->toClock(),
            '%value-to-scientific' => $this->toScientific(),
            '%value-to-percent' => $this->toPercent(),
            '%value-to-currency' => $this->toCurrency(),
            '%value-to-summary' => $this->toSummary(),
            '%value-to-roman-numeral' => $this->toRomanNumeral(),
            default => throw SpellNumberExceptions::create($messageException),
        };
    }
}
