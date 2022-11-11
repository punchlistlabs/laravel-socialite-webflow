# laravel-socialite-webflow

Webflow Oauth Driver for Laravel Socialite

## Installation

You can install the package via composer:

```bash
composer require punchlist/laravel-socialite-webflow
```

## Usage

Once you install the package, add the next config values in you `config/services.php` configuration file:

```php
'webflow' => [
    'base_uri' => env('WEBFLOW_URI'),
    'client_id' => env('WEBFLOW_CLIENT_ID'),
    'client_secret' => env('WEBFLOW_CLIENT_SECRET'),
    'redirect' => env('WEBFLOW_REDIRECT_URI'),
],
```

Then, you can use the driver as you would use it in the Laravel Socialite's official [documentation](https://laravel.com/docs/9.x/socialite). Use `webflow` keyword when you want to instantiate the driver:

```php
$user = Socialite::driver('webflow')->user();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

If you discover any security related issues, please email engineering@punchlist.com or use issue tracker.

## Sponsorship

Development of this package is sponsored by Punchlist learn more [about us](https://punchlist.com)!

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
