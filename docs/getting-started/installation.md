---
title: Installation
description: Check Laravel and PHP compatibility, enable Intl, and install SpellNumber with Composer.
editLink: true
outline: deep
---

# Installation

Run the commands below from the root of your Laravel application: the directory that contains both `artisan` and `composer.json`. If you don't have an application yet, create one by following the [Laravel installation guide](https://laravel.com/docs/13.x/installation) for the version you want to use.

## 1. Check your environment {#runtime-requirements}

SpellNumber 5 supports Laravel 8–13 and requires PHP with `intl` and `mbstring` enabled. The effective PHP minimum depends on your Laravel version:

| Laravel | Minimum PHP for SpellNumber 5 |
| --- | --- |
| 13.x | 8.3 |
| 12.x or 11.x | 8.2 |
| 10.x | 8.1 |
| 9.x | 8.0.2 |
| 8.x | 8.0 |

Your application's other dependencies can require a newer PHP version. CI tests Laravel 12 and 13 on compatible PHP 8.2–8.5 combinations. Support for later Laravel majors is not assumed.

```shell
php -v
php artisan --version
composer --version
php --ri intl
php --ri mbstring
```

`php --ri intl` should report `Internationalization support => enabled` and an ICU version. `php --ri mbstring` should report that multibyte support is enabled. If a command reports that an extension is not present, enable it before installing.

### Enable missing extensions

::: code-group

```ini [Windows: php.ini]
extension=intl
extension=mbstring
```

```shell [Debian / Ubuntu]
sudo apt install php-intl php-mbstring
```

:::

- **Windows:** Run `php --ini` and edit the file shown under **Loaded Configuration File**, not an example `.ini` file. Uncomment the two lines if they already exist. If your terminal is running a different PHP than expected, `where.exe php` lists the binaries on your PATH.
- **Debian / Ubuntu:** The unsuffixed packages follow the distribution's default PHP. If you have multiple PHP versions, install the matching packages for the PHP binary and web runtime you use, such as `php8.3-intl` and `php8.3-mbstring` where available.
- **Containers or hosted PHP:** Enable the extensions in the container image or hosting control panel where Laravel runs. Installing an extension on the host does not install it in a container.

Re-run both `php --ri` commands after enabling the extensions. If the CLI works but website requests fail, restart the web PHP process after enabling the modules there as well. See [runtime troubleshooting](../reference/troubleshooting.md#check-the-php-runtime).

## 2. Install the package

```shell
composer require "rmunate/spell-number:^5.0"
composer show rmunate/spell-number
```

The second command should list an installed `5.x` version. Keep Composer's platform checks enabled; ignoring a missing extension or PHP requirement does not make conversions work.

## 3. Check provider registration {#provider-registration}

Laravel discovers `Rmunate\Utilities\Providers\SpellNumberProvider` automatically. If you disabled discovery for this package, add the following **entry** to your application's existing provider list:

```php
\Rmunate\Utilities\Providers\SpellNumberProvider::class,
```

- In the default Laravel 11–13 application structure, add it to the array returned by `bootstrap/providers.php`.
- In Laravel 8–10 or an upgraded app that still uses the older structure, add it to the application providers in `config/app.php`. Keep the entries already there.

No facade alias or published configuration is required. Continue to the [Quickstart](./quickstart.md) to verify a first conversion.
