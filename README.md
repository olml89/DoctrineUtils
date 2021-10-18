# DoctrineUtils
A collection of utils to ease up working with Doctrine
- [**SoftDeleteableFilterSwitch**](): provides an easy way to enable and disable 
  the [Gedmo SoftDeleteable](https://github.com/doctrine-extensions/DoctrineExtensions/blob/main/doc/softdeleteable.md) extension. 
  This is useful if you want to hard-delete a particular item while maintaning the soft-delete policy for the rest, or if you want
  to recover soft-deleted items.

## Installation
    composer require olml89/doctrine-utils

## Requirements
- PHP >= 8.0
- [doctrine/orm](https://github.com/doctrine/orm) >= 2.9
- [gedmo/doctrine-extensions ](https://github.com/doctrine-extensions/DoctrineExtensions) v3.2.0: Doctrine2 behavioral extensions