---
title: Configuration File
editLink: true
outline: deep
---

# Laravel Configuration File

This is optional.

You can publish the config-file with:

``` bash
php artisan vendor:publish --provider="Rmunate\\Utilities\\Providers\\SpellNumberProvider" --tag="config"
```

[View File on GitHub](https://github.com/rmunate/SpellNumber/blob/1cca5565d6b8c049683357bcbb964b70bcfc4a92/config/spell-number.php)

The configuration file will prove valuable if you intend to consistently use a single target language for converting numbers into letters.

It also provides a comprehensive global output manipulation feature, empowering you to implement various adjustments or restore settings to the default package letter output.
