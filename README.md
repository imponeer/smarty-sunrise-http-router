[![License](https://img.shields.io/github/license/imponeer/smarty-sunrise-http-router.svg)](LICENSE)
[![GitHub release](https://img.shields.io/github/release/imponeer/smarty-sunrise-http-router.svg)](https://github.com/imponeer/smarty-sunrise-http-router/releases) [![PHP](https://img.shields.io/packagist/php-v/imponeer/smarty-sunrise-http-router.svg)](http://php.net) 
[![Packagist](https://img.shields.io/packagist/dm/imponeer/smarty-sunrise-http-router.svg)](https://packagist.org/packages/imponeer/smarty-sunrise-http-router)

# Smarty Sunrise HTTP Router Extensions

This library adds some `url` function that generates named route for [Sunrise HTTP Router](https://github.com/sunrise-php/http-router).

## Installation

To install and use this package, we recommend to use [Composer](https://getcomposer.org):

```bash
composer require imponeer/smarty-sunrise-http-router
```

Otherwise, you need to include manually files from `src/` directory. 

## Registering in Smarty

If you want to use these extensions from this package in your project you need to add them as a native [Smarty 5](https://www.smarty.net/) extension:
```php
$smarty = new \Smarty\Smarty();
$extension = new \Imponeer\Smarty\Extensions\SunriseHTTPRouter\SunriseHttpRouterExtension($router);
$smarty->addExtension($extension);
```

## Using from templates

To generate url for named route:
```smarty
<a href="{url name='ROUTE_NAME' attributes=['p1'=>'v1']}">go there</a>
```

`attributes` can be used also as shortcut `attr` or not used at all. This param maybe needed depending on a route.

## How to contribute?

We welcome bug reports, questions, and pull requests.

- Check existing [issues](https://github.com/imponeer/smarty-sunrise-http-router/issues) and open a new one if you want to propose changes or report a problem (please include steps to reproduce when relevant).
- Fork the repository and create a branch for your change.
- Install development dependencies with `composer install` and run the test suite with `composer test` to ensure everything passes before and after your edits.
- Run static analysis with `composer phpstan`.
- Keep changes focused; when you modify behavior, add or adjust tests in `tests/` to cover it.
- Open a pull request describing what changed and why.

If you are new to contributing on GitHub, start with the official guide: [Contributing to projects](https://docs.github.com/en/get-started/quickstart/contributing-to-projects).
