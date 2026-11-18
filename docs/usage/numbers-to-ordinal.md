---
title: Numbers to Ordinals
editLink: true
outline: deep
---

# Numbers to Ordinals

Use `toOrdinal()` for rank, position, or order. Start with `integer(2)` for a PHP integer or `value('2')` for an integer string. `value(2.0)`, `value('2.0')`, and `float('2')` are classified as decimals even though their numeric magnitude is a whole number; `toOrdinal()` rejects them.

```php
use Rmunate\Utilities\SpellNumber;

SpellNumber::integer(2)->locale('en')->toOrdinal();
// "second"

SpellNumber::value('2')->locale('es')->toOrdinal();
// "segundo"

SpellNumber::integer(2)->locale('es')->toOrdinal(SpellNumber::ORDINAL_FEMALE);
// "segunda"

SpellNumber::integer(2)->locale('en')->toOrdinal(SpellNumber::ORDINAL_FEMALE);
// "second": English uses the generic rule
```

## Rule selection

Pass a mode directly to override the `default.ordinal_output` value in the [configuration](./config-file.md). These are the preferred names and constants:

| Requested mode | Pass a string or constant |
| --- | --- |
| Default | `'default'` or `SpellNumber::ORDINAL_DEFAULT` |
| Masculine | `'male'` or `SpellNumber::ORDINAL_MALE` |
| Feminine | `'female'` or `SpellNumber::ORDINAL_FEMALE` |

- Default mode tries ICU's generic ordinal rule, then the masculine and feminine rules in that order. Spanish uses the masculine rule by default.
- For an explicit gender, SpellNumber tries the corresponding rule, then the generic rule where available (for example, in English).
- A locale may support cardinal words without ordinal words, or may not spell certain values such as negative ranks. If no compatible rule can spell the number, SpellNumber raises `SpellNumberExceptions` rather than returning a cardinal or a numeric abbreviation.

If you're migrating existing code, `ordinal` is accepted as an alias for `default`; `masculine` and `ordinal-masculine` for `male`; and `feminine` and `ordinal-feminine` for `female`. Unknown modes raise an exception.
