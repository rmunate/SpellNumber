---
title: Release Notes
editLink: true
outline: deep
---

# Release Notes

## [4.2.0] - 2023-11-20

### Added

- **Vietnamese Language Support**: Introduced connectors and replacements for the Vietnamese language.

### Changed

- **TitleCase to LowerCase**: In response to specific language nuances, output is now in lowercase. Developers have the option to modify the output as needed, keeping in mind the use of the callback function.

To swiftly revert to title-formatted output, simply publish the configuration file:

```bash
php artisan vendor:publish --provider="Rmunate\\Utilities\\Providers\\SpellNumberProvider" --tag="config"
```

Then, locate the callback function and adjust the return statement in the configuration file:

```php
return [
  //...
  'callback_output' => function ($data) {

    // Your logic here...

    return \Illuminate\Support\Str::title($data->getWords());
  }, 
]
```

## [4.2.2] - 2023-11-28

### Changed

- **Zero-width spaces:** Characters (\u{AD}, \u{200B}) are removed from the translation outputs.