# Extract text from a Word Doc

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jaybizzle/doc-to-text.svg?style=flat-square)](https://packagist.org/packages/jaybizzle/doc-to-text)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/JayBizzle/doc-to-text/master.svg?style=flat-square)](https://travis-ci.org/jaybizzle/doc-to-text)
[![Quality Score](https://img.shields.io/scrutinizer/g/jaybizzle/doc-to-text.svg?style=flat-square)](https://scrutinizer-ci.com/g/jaybizzle/doc-to-text)
[![Total Downloads](https://img.shields.io/packagist/dt/jaybizzle/doc-to-text.svg?style=flat-square)](https://packagist.org/packages/jaybizzle/doc-to-text)

This package provides a class to extract text from a Word Doc.

```php
<?php

use Jaybizzle\DocToText\Doc;

echo Doc::getText('book.doc'); // returns the text from the doc
```

## Requirements

Behind the scenes this package leverages [antiword](https://en.wikipedia.org/wiki/Antiword). You can verify if the binary installed on your system by issuing this command:

```bash
which antiword
```

If it is installed it will return the path to the binary.

To install the binary you can use this command on Ubuntu or Debian:

```bash
apt-get install antiword
```

## Installation

You can install the package via composer:

```bash
composer require jaybizzle/doc-to-text
```

## Usage

Extracting text from a Doc is easy.

```php
$text = (new Doc())
    ->setDoc('book.doc')
    ->text();
```

Or easier:

```php
echo Doc::getText('book.doc');
```

By default the package will assume that the `antiword` command is located at `/usr/bin/antiword`.
If it is located elsewhere pass its binary path to the constructor

```php
$text = (new Doc('/custom/path/to/antiword'))
    ->setDoc('book.doc')
    ->text();
```

or as the second parameter to the `getText` static method:

```php
echo Doc::getText('book.doc', '/custom/path/to/antiword');
```

Sometimes you may want to use [antiword options](https://linux.die.net/man/1/antiword). To do so you can set them up using the `setOptions` method.

```php
$text = (new Doc())
    ->setDoc('table.doc')
    ->setOptions(['f', 'w 80'])
    ->text()
;
```

or as the third parameter to the `getText` static method:

```php
echo Doc::getText('book.doc', null, ['f', 'w 80']);
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information about what has changed recently.

## Testing

```bash
 composer test
```

## Security

If you discover any security related issues, please email mbeech@mark-beech.co.uk instead of using the issue tracker.

## Credits

- [Mark Beech](https://github.com/jaybizzle)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
