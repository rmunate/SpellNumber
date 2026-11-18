<?php

declare(strict_types=1);

namespace Rmunate\Utilities\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Rmunate\Utilities\Exceptions\SpellNumberExceptions;
use Rmunate\Utilities\SpellNumber;
use stdClass;

/**
 * Exercise the public conversion API without bootstrapping a Laravel application.
 */
final class SpellNumberTest extends TestCase
{
    /** Verify a complete decimal conversion in each preset language. */
    #[DataProvider('languages')]
    public function testPresetLanguages(string $locale, string $expected): void
    {
        self::assertSame($expected, SpellNumber::value('2.5')->locale($locale)->toLetters());
    }

    /**
     * Supply representative spellings and their localized connectors.
     *
     * @return iterable<string, array{string, string}>
     */
    public static function languages(): iterable
    {
        yield 'German' => ['de', 'zwei und fünfzig'];
        yield 'English' => ['en', 'two and fifty'];
        yield 'Spanish' => ['es', 'dos con cincuenta'];
        yield 'Farsi' => ['fa', 'دو ممیز پنجاه'];
        yield 'French' => ['fr', 'deux et cinquante'];
        yield 'Hindi' => ['hi', 'दो और पचास'];
        yield 'Italian' => ['it', 'due con cinquanta'];
        yield 'Polish' => ['pl', 'dwa i pięćdziesiąt'];
        yield 'Portuguese' => ['pt', 'dois com cinquenta'];
        yield 'Romanian' => ['ro', 'doi cu cincizeci'];
        yield 'Vietnamese' => ['vi', 'hai và năm mươi'];
    }

    /** Verify that decimal strings preserve fractional digits, while floats remain supported. */
    public function testDecimalInput(): void
    {
        self::assertSame('one hundred', SpellNumber::integer(100)->toLetters());
        self::assertSame(
            'one hundred twenty-three million four hundred fifty-six thousand seven hundred eighty-nine and twelve',
            SpellNumber::value(123456789.12)->toLetters()
        );
        self::assertSame(
            'twelve thousand three hundred forty-five and two hundred thirty',
            SpellNumber::float('12345.230')->toLetters()
        );
        self::assertSame('ten trillion and twenty-five', SpellNumber::value(10_000_000_000_000.25)->toLetters());
        self::assertSame('eight and three', SpellNumber::value(' +0008.03 ')->toLetters());
        self::assertSame('two and zero', SpellNumber::float('2.0')->toLetters());
    }

    /** Preserve the sign in a negative fractional value even when its whole part is zero. */
    public function testNegativeDecimals(): void
    {
        self::assertSame('minus zero and fifty', SpellNumber::value(-0.5)->toLetters());
        self::assertSame('minus zero dollars and one cent', SpellNumber::float('-.01')->toMoney());
        self::assertSame('menos dos con cincuenta', SpellNumber::value('-2.5')->locale('es')->toLetters());
    }

    /** Keep large integers exact instead of sending them to ICU as binary floats. */
    public function testIntegerPrecision(): void
    {
        if (PHP_INT_SIZE < 8) {
            self::markTestSkipped('This integer requires a 64-bit PHP runtime.');
        }

        self::assertStringEndsWith(
            'seven hundred forty thousand nine hundred ninety-three',
            SpellNumber::value('9007199254740993')->toLetters()
        );
    }

    /** Surface ICU falling back to digits instead of returning them as words. */
    public function testRejectsAnIntegerIcuCannotSpell(): void
    {
        if (PHP_INT_SIZE < 8) {
            self::markTestSkipped('The ICU fallback is reached with 64-bit integer bounds.');
        }

        $this->expectException(SpellNumberExceptions::class);
        $this->expectExceptionMessage('ICU could not spell out');

        SpellNumber::integer(PHP_INT_MAX)->toLetters();
    }

    /** Check singular currency names and scale connectors, including a nonzero remainder. */
    public function testMoneyGrammar(): void
    {
        self::assertSame('one dollar and one cent', SpellNumber::float('1.01')->toMoney());
        self::assertSame('one million one dollars', SpellNumber::integer(1_000_001)->toMoney());
        self::assertSame('un millón de pesos', SpellNumber::integer(1_000_000)->locale('es')->currency('Pesos')->toMoney());
        self::assertSame(
            'un millón veintiún pesos con un centavo',
            SpellNumber::float('1000021.01')->locale('es')->currency('Pesos')->fraction('Centavos')->toMoney()
        );
        self::assertSame('treinta y un pesos', SpellNumber::integer(31)->locale('es')->currency('pesos')->toMoney());
        self::assertSame('un million d’euros', SpellNumber::integer(1_000_000)->locale('fr')->currency('euros')->toMoney());
        self::assertSame('एक सौ रूपये', SpellNumber::value(100)->locale('hi')->currency('रूपये')->toMoney());
    }

    /** Respect regional rules and use the ICU separator outside the preset languages. */
    public function testSpecificLocaleConversion(): void
    {
        self::assertContains('fr_CH', SpellNumber::getAllLocales());
        self::assertSame('septante', SpellNumber::value(70)->locale('fr-CH', SpellNumber::SPECIFIC_LOCALE)->toLetters());
        self::assertSame('twee, vijftig', SpellNumber::value('2.5')->locale('nl', SpellNumber::SPECIFIC_LOCALE)->toLetters());
    }

    /** Require an explicit opt-in for regional locale codes and reject nonexistent locales. */
    #[DataProvider('rejectedLocales')]
    public function testRejectsInvalidLocale(string $locale, bool $specific): void
    {
        $this->expectException(SpellNumberExceptions::class);

        SpellNumber::value(2)->locale($locale, $specific);
    }

    /** @return iterable<string, array{string, bool}> */
    public static function rejectedLocales(): iterable
    {
        yield 'regional without opt-in' => ['es_MX', false];
        yield 'unknown language' => ['zz_ZZ', true];
        yield 'empty locale' => ['', true];
    }

    /** An installed resource locale must not spell a number in an unrelated language. */
    public function testRejectsIcuCrossLanguageFallback(): void
    {
        $this->expectException(SpellNumberExceptions::class);
        $this->expectExceptionMessage('does not provide spellout rules');

        SpellNumber::value(2)->locale('agq', SpellNumber::SPECIFIC_LOCALE)->toLetters();
    }

    /** Choose the correct rule or the available neutral rule in gender-insensitive locales. */
    public function testOrdinalModes(): void
    {
        self::assertSame('second', SpellNumber::value('2')->toOrdinal());
        self::assertSame('minus second', SpellNumber::integer(-2)->toOrdinal(SpellNumber::ORDINAL_FEMALE));
        self::assertSame('segundo', SpellNumber::integer(2)->locale('es')->toOrdinal());
        self::assertSame('segunda', SpellNumber::integer(2)->locale('es_MX', true)->toOrdinal('feminine'));
    }

    /** Reject decimal input and unavailable ordinal spellout rules instead of returning cardinals. */
    #[DataProvider('unsupportedOrdinals')]
    public function testRejectsUnsupportedOrdinal(int|float|string $number, string $locale, ?string $mode): void
    {
        $this->expectException(SpellNumberExceptions::class);

        SpellNumber::value($number)->locale($locale)->toOrdinal($mode);
    }

    /** @return iterable<string, array{int|float|string, string, ?string}> */
    public static function unsupportedOrdinals(): iterable
    {
        yield 'decimal string' => ['2.0', 'en', null];
        yield 'native float' => [2.0, 'en', null];
        yield 'unknown mode' => [2, 'en', 'wrong'];
        yield 'no ICU spellout rule' => [2, 'fa', null];
    }

    /** Raise a package exception for invalid inputs before any coercion or truncation can occur. */
    #[DataProvider('invalidValues')]
    public function testRejectsInvalidValues(string $factory, mixed $value): void
    {
        $this->expectException(SpellNumberExceptions::class);

        SpellNumber::{$factory}($value);
    }

    /** @return iterable<string, array{string, mixed}> */
    public static function invalidValues(): iterable
    {
        yield 'boolean' => ['value', false];
        yield 'null' => ['value', null];
        yield 'array' => ['value', []];
        yield 'object' => ['value', new stdClass()];
        yield 'NaN' => ['value', NAN];
        yield 'infinite' => ['value', INF];
        yield 'scientific string' => ['value', '1e3'];
        yield 'scientific float' => ['value', 1e-20];
        yield 'grouped number' => ['value', '1,000.00'];
        yield 'missing digits' => ['value', '-.'];
        yield 'out-of-range integer' => ['value', (string) PHP_INT_MAX.'0'];
        yield 'out-of-range fractional digits' => ['float', '0.'.PHP_INT_MAX.'0'];
        yield 'non-numeric decimal string' => ['float', 'invalid'];
        yield 'integer factory with numeric string' => ['integer', '2'];
        yield 'float factory with native float' => ['float', 2.5];
    }

    /** Preserve the documented bound dispatcher for existing macros. */
    public function testMacrosCanDispatchConversions(): void
    {
        SpellNumber::macro('inWords', function (string $method): mixed {
            return $this->spell($method, SpellNumber::ORDINAL_FEMALE);
        });

        try {
            $number = SpellNumber::value(2)->locale('es')->currency('pesos');

            self::assertSame('dos', $number->inWords(SpellNumber::TO_LETTERS));
            self::assertSame('dos pesos', $number->inWords(SpellNumber::TO_MONEY));
            self::assertSame('segunda', $number->inWords(SpellNumber::TO_ORDINAL));

            $this->expectException(SpellNumberExceptions::class);
            $number->inWords('unknown');
        } finally {
            SpellNumber::flushMacros();
        }
    }
}
