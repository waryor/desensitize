#### Stats:
![Packagist Stars](https://img.shields.io/packagist/stars/waryor/desensitize?label=packagist-stars)


#### Tests:
[![Tests](https://github.com/waryor/desensitize/actions/workflows/tests.yml/badge.svg)](https://github.com/waryor/desensitize/actions/workflows/tests.yml)




## Desensitize

The package provides an easy way to desensitize your routes in your Laravel application. In short, Desensitize makes your routes case-insensitive, so you can access any of your routes whether they are lowercase, uppercase, or both.

## Installation

```php
composer require waryor/desensitize
```

## Usage

Register the app in `\bootstrap\app.php` and change the `Applocation` namespace to `Waryor\Desensitize\Foundation\` like so:
```php
$app = new Waryor\Desensitize\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);
```

To use this package simply add the following line to your `boot` method in your `app/Providers/RouteServiceProvider.php` file:
```php
Desensitize::initialize();
```

If you want to desensitize your routes including a sub-folder, you can do so by passing the sub-folder to the `Desensitize::initialize()` method:
```php
Desensitize::initialize("/sub-folder");
```

## Credits

- [Waryor](https://waryor.com)
- [All contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
