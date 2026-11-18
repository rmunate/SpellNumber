<?php

declare(strict_types=1);

namespace Rmunate\Utilities\Tests;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use PHPUnit\Framework\TestCase;
use Rmunate\Utilities\Callback\DataResponse;
use Rmunate\Utilities\Exceptions\SpellNumberExceptions;
use Rmunate\Utilities\Providers\SpellNumberProvider;
use Rmunate\Utilities\SpellNumber;

/**
 * Exercise defaults, configuration publishing, and output customization in Laravel.
 */
final class LaravelConfigurationTest extends TestCase
{
    /** A real Laravel application with an in-memory configuration repository. */
    private Application $app;

    /** Make the framework's application and config repository available to the provider. */
    protected function setUp(): void
    {
        parent::setUp();

        $this->app = new Application(dirname(__DIR__));
        $this->app->instance('config', new Repository(['app' => ['locale' => 'es_CO']]));
        Facade::setFacadeApplication($this->app);
    }

    /** Release the framework application so standalone tests do not use its config. */
    protected function tearDown(): void
    {
        Facade::clearResolvedInstances();
        Facade::setFacadeApplication(null);
        Application::setInstance(null);

        parent::tearDown();
    }

    /** Register the provider defaults without requiring vendor:publish. */
    public function testProviderUsesTheApplicationLocaleUntilOverridden(): void
    {
        $this->app->register(SpellNumberProvider::class);
        $this->app->boot();

        self::assertSame('cien', SpellNumber::integer(100)->toLetters());

        $this->app['config']->set('app.locale', 'ja');
        self::assertSame('one hundred', SpellNumber::integer(100)->toLetters());

        $this->app['config']->set('spell-number.default.locale', 'pt');
        self::assertSame('cem', SpellNumber::integer(100)->toLetters());

        $paths = ServiceProvider::pathsToPublish(SpellNumberProvider::class, 'config');
        self::assertContains($this->app->configPath('spell-number.php'), array_values($paths));
    }

    /** Respect partial app config and global settings without losing unspecified defaults. */
    public function testProviderRespectsAnExistingConfiguration(): void
    {
        $this->app['config']->set('spell-number.default', [
            'lang'            => 'es_MX',
            'specific_locale' => true,
            'currency'        => 'pesos',
            'ordinal_output'  => 'female',
        ]);
        $this->app->register(SpellNumberProvider::class);

        self::assertSame('dos pesos con cincuenta cents', SpellNumber::value('2.5')->toMoney());
        self::assertSame('segunda', SpellNumber::value(2)->toOrdinal());
        self::assertSame('septante', SpellNumber::value(70)->locale('fr_CH')->toLetters());
    }

    /** Pass the correct original value, settings, and replaced output to each callback. */
    public function testCallbacksReceiveConvertedWordsAndMetadata(): void
    {
        $this->app['config']->set('spell-number.replacements.es', [
            'DOS' => 'dúo',
        ]);
        $this->app['config']->set('spell-number.callback_output', [self::class, 'outputMetadata']);
        $this->app->register(SpellNumberProvider::class);

        $money = SpellNumber::float('2.5')->locale('es-MX', true)->currency('Pesos')->fraction('Centavos')->toMoney();
        self::assertSame(['toMoney', 'double', '2.5', 'es', 'es-MX', 'dúo pesos con cincuenta centavos', null, 'Pesos', 'Centavos'], $money);

        $letters = SpellNumber::integer(2)->toLetters();
        self::assertSame(['toLetters', 'integer', 2, 'es', 'es', 'dúo', null, null, null], $letters);

        $ordinal = SpellNumber::integer(2)->toOrdinal(SpellNumber::ORDINAL_FEMALE);
        self::assertSame(['toOrdinal', 'integer', 2, 'es', 'es', 'segunda', 'female', null, null], $ordinal);
    }

    /** Enable legacy closure callbacks when the application is not caching config. */
    public function testClosureCallbacksRemainCallable(): void
    {
        $this->app['config']->set('spell-number.callback_output', static fn (DataResponse $data): string => strtoupper($data->words));
        $this->app->register(SpellNumberProvider::class);

        self::assertSame('CIEN', SpellNumber::value(100)->toLetters());
    }

    /** Report an invalid non-null callback instead of silently ignoring it. */
    public function testRejectsInvalidCallbackConfiguration(): void
    {
        $this->app['config']->set('spell-number.callback_output', 'not_a_callable');

        $this->expectException(SpellNumberExceptions::class);

        SpellNumber::value(100)->toLetters();
    }

    /**
     * Represent a config-cache-safe callable that returns application-specific output.
     *
     * @return array{?string, ?string, mixed, ?string, ?string, ?string, ?string, ?string, ?string}
     */
    public static function outputMetadata(DataResponse $data): array
    {
        return [
            $data->getMethod(),
            $data->getType(),
            $data->getValue(),
            $data->getLang(),
            $data->getLocale(),
            $data->getWords(),
            $data->getMode(),
            $data->getCurrency(),
            $data->getFraction(),
        ];
    }
}
