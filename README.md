# SpellNumber for Laravel

[![CI and GitHub Pages](https://github.com/rmunate/SpellNumber/actions/workflows/deploy.yml/badge.svg)](https://github.com/rmunate/SpellNumber/actions/workflows/deploy.yml)
[![Packagist](https://img.shields.io/packagist/v/rmunate/spell-number)](https://packagist.org/packages/rmunate/spell-number)

SpellNumber **5.0.0** uses PHP Intl to spell out numbers, money amounts, and ordinals. It includes formatting defaults for 11 languages, configurable currency labels and output replacements, and Laravel macros.

## Installation

- Laravel 8–13 and a PHP version supported by your Laravel release.
- PHP 8.0 or later with `intl` and `mbstring` enabled. **Laravel 13 requires PHP 8.3 or later.**

```bash
composer require rmunate/spell-number:^5.0
```

Laravel discovers the service provider automatically. Publishing the configuration is optional.

## Usage

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::value(100)->locale('en')->toLetters();
// one hundred

SpellNumber::float('1.01')->locale('es')->currency('pesos')->fraction('centavos')->toMoney();
// un peso con un centavo

SpellNumber::integer(2)->locale('es')->toOrdinal(SpellNumber::ORDINAL_FEMALE);
// segunda
```

For exact decimals, pass a string with a dot and no grouping separators. Output is lowercase by default; ICU versions can differ in their spellings and available ordinal rules.

[Documentation](https://rmunate.github.io/SpellNumber/) · [Laravel quickstart](./docs/getting-started/quickstart.md) · [API reference](./docs/reference/api.md) · [Upgrade to 5.0.0](./docs/getting-started/changelog.md)

## Contributing

Run `composer test` for the PHP suite. See the [contribution guide](./docs/contribute/contribution.md) for docs builds, CI, and release steps.

Thanks to [Ashok Devatwal](https://github.com/ashokdevatwal), [Olsza](https://github.com/olsza), [Siros Fakhri](https://github.com/sirosfakhri), [Jens Twesmann](https://github.com/jetwes), [Gabriel Rausch](https://github.com/gdsrmygdsrjr), [Alejandro Diaz](https://github.com/alejandrodiazpinilla), [Frank Sepulveda](https://github.com/socieboy), [Ngô Quốc Đạt](https://github.com/datlechin), and everyone who has contributed.

Released under the [MIT License](./LICENSE.md).
