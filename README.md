#Desensitize
The package provides an easy way to desensitize your routes in your Laravel application. In short, Desensitize makes your routes case-insensitive, so you can access any of your routes whether they are lowercase, uppercase, or both.

##Installation
```php
composer require waryor/desensitize
```

#Usage
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