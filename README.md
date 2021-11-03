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

If you want to use these extensions from this package in your project you need register them with [`registerPlugin` function](https://www.smarty.net/docs/en/api.register.plugin.tpl) from [Smarty](https://www.smarty.net). For example:
```php
$smarty = new \Smarty();
$urlPlugin = new \Imponeer\Smarty\Extensions\SunriseHTTPRouter\Url($router);
$smarty->registerPlugin('function', $urlPlugin->getName(), [$urlPlugin, 'execute']);
```

## Using from templates

To generate url for named route:
```smarty
<a href="{url name='ROUTE_NAME' attributes=['p1'=>'v1']}">go there</a>
```

`attributes` can be used also as shortcut `attr` or not used at all. 

## How to contribute?

If you want to add some functionality or fix bugs, you can fork, change and create pull request. If you not sure how this works, try [interactive GitHub tutorial](https://try.github.io).

If you found any bug or have some questions, use [issues tab](https://github.com/imponeer/smarty-sunrise-http-router/issues) and write there your questions.
