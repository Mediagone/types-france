# Types France

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE)

Value Objects are small and **immutable** classes representing typed values usually implemented using PHP primitive types. However, objects can embed validation to ensure that your data is **always valid** without adding any check elsewhere in your code.

That's why you should ALWAYS use Value Objects rather than primitive types.


## Installation
This package requires **PHP 7.4+**

Add it as Composer dependency:
```sh
$ composer require mediagone/types-france
```


## List of available Value Objects

All value objects implement a common `ValueObject` interface and `JsonSerializable`. 


## License

_Types France_ is licensed under MIT license. See LICENSE file.



[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg
[ico-version]: https://img.shields.io/packagist/v/mediagone/types-france.svg
[ico-downloads]: https://img.shields.io/packagist/dt/mediagone/types-france.svg

[link-packagist]: https://packagist.org/packages/mediagone/types-france
[link-downloads]: https://packagist.org/packages/mediagone/types-france
