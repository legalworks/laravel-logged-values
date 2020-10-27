# legalworks/laravel-logged-values

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](http://opensource.org/licenses/MIT)

Ever needed to store simple values easily, that could change over time or even in the future? When Event Sourcing is just a bit too much? This is for you... maybe.

## Installation

Via Composer

``` bash
$ composer require legalworks/laravel-logged-values
```

## Usage

### Add trait

``` php
use Legalworks\LoggedValues\HasLoggedValues;

class SomeModel extends Model{
    use HasLoggedValues;
    ...
}
```

### Add any logged values

```
$someModel->logValue('pages', 500, [
    'effective_at' => now(), //optional, defaults to now()
    'description' => null, //optional
]);

```

### Get logged values

``` php
$someModel->loggedValues; //all logged values
$someModel->groupedValues; //all values grouped by key
$someModel->pastValues;
$someModel->futureValues;

$someModel->getLatestValue('pages', '2020-10-27 12:00:00'); //get the latest value of the given key before given (optional) datetime
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [JayAhr][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/legalworks/laravel-logged-values.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/legalworks/laravel-logged-values.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/legalworks/laravel-logged-values
[link-downloads]: https://packagist.org/packages/legalworks/laravel-logged-values
[link-author]: https://github.com/legalworks
[link-contributors]: ../../contributors
