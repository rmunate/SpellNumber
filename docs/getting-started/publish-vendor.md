---
title: Publish Configuration
editLink: true
outline: deep
---

# Publish Configuration

Publishing copies the package's configuration into your Laravel application so you can edit it. Skip this step if the defaults and fluent methods are enough.

## 1. Publish the file

Run this command from the directory containing `artisan` (Bash, zsh, or PowerShell):

```shell
php artisan vendor:publish --provider='Rmunate\Utilities\Providers\SpellNumberProvider' --tag=config
```

You should now have `config/spell-number.php` **in your application**. Edit that copy, not the file under `vendor/`.

::: warning Already published?
Don't add `--force` unless you intend to overwrite the application's copy. Compare it with the vendor file and merge the changes you want. If you're upgrading from 4.x, also check the [upgrade notes](./changelog.md#500).
:::

## 2. Make Laravel read your changes

When developing locally, clear an existing configuration cache after changing the file:

```shell
php artisan config:clear
```

For a deployment that uses cached configuration, rebuild the cache using the deployed configuration:

```shell
php artisan config:cache
```

Continue to the [settings reference](../usage/config-file.md) or add a [cache-safe output callback](../usage/config-custom-callback.md).
