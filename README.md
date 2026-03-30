[![License](https://img.shields.io/github/license/imponeer/smarty-sunrise-http-router.svg)](LICENSE) [![GitHub release](https://img.shields.io/github/release/imponeer/smarty-sunrise-http-router.svg)](https://github.com/imponeer/smarty-sunrise-http-router/releases) [![PHP](https://img.shields.io/packagist/php-v/imponeer/smarty-sunrise-http-router.svg)](http://php.net) [![Packagist](https://img.shields.io/packagist/dm/imponeer/smarty-sunrise-http-router.svg)](https://packagist.org/packages/imponeer/smarty-sunrise-http-router) [![Smarty version requirement](https://img.shields.io/packagist/dependency-v/imponeer/smarty-sunrise-http-router/smarty%2Fsmarty)](https://smarty-php.github.io)

# Smarty Sunrise HTTP Router

This library exposes Sunrise HTTP Router named routes to Smarty through a `{url}` template function, allowing templates to generate links without hardcoding paths.
It is designed for applications that keep routing logic in [Sunrise HTTP Router](https://github.com/sunrise-php/http-router) and want those routes available directly inside Smarty views.

## Installation

To install and use this package, we recommend to use [Composer](https://getcomposer.org):

```bash
composer require imponeer/smarty-sunrise-http-router
```

Otherwise, you need to include manually files from `src/` directory.

## Setup

### Modern Smarty Extension (Recommended)

Register the extension with your Smarty instance and provide a configured router:

```php
use Imponeer\Smarty\Extensions\SunriseHTTPRouter\SunriseHttpRouterExtension;
use Sunrise\Http\Router\RouterInterface;

// $router is a configured Sunrise\Http\Router\RouterInterface instance
$router = $container->get(RouterInterface::class);

$smarty = new \Smarty\Smarty();
$smarty->addExtension(new SunriseHttpRouterExtension($router));
```

### Using with Dependency Injection Containers

#### Symfony Container

```yaml
# config/services.yaml
services:
    _defaults:
        autowire: true
        autoconfigure: true

    Imponeer\Smarty\Extensions\SunriseHTTPRouter\SunriseHttpRouterExtension:
        arguments:
            - '@Sunrise\Http\Router\RouterInterface'

    \Smarty\Smarty:
        calls:
            - [addExtension, ['@Imponeer\Smarty\Extensions\SunriseHTTPRouter\SunriseHttpRouterExtension']]
```

#### PHP-DI Container

```php
use Imponeer\Smarty\Extensions\SunriseHTTPRouter\SunriseHttpRouterExtension;
use Sunrise\Http\Router\RouterInterface;
use function DI\create;
use function DI\get;

return [
    SunriseHttpRouterExtension::class => create()->constructor(get(RouterInterface::class)),
    \Smarty\Smarty::class => create()->method('addExtension', get(SunriseHttpRouterExtension::class)),
];
```

#### League Container

```php
use Imponeer\Smarty\Extensions\SunriseHTTPRouter\SunriseHttpRouterExtension;
use Sunrise\Http\Router\RouterInterface;

$container = new \League\Container\Container();

$container->add(RouterInterface::class, function () {
    // Build and return your RouterInterface implementation
});

$container->add(\Smarty\Smarty::class, function () use ($container) {
    $smarty = new \Smarty\Smarty();
    $smarty->addExtension(new SunriseHttpRouterExtension($container->get(RouterInterface::class)));

    return $smarty;
});
```

## Usage

The `{url}` function renders a URL for a named route defined in Sunrise HTTP Router.

### Generate a route URL

```smarty
{url name="home"}
```

### Passing route attributes

```smarty
{url name="article" attributes=["slug" => "introduction-to-router"]}
{* or the shorter alias *}
{url name="article" attr=["slug" => "introduction-to-router"]}
```

### Handling missing attributes

If required route attributes are not provided or the route name does not exist, the router will throw an exception so you can catch and handle the error in your application.

## Development

### Code Quality Tools

- **PHPUnit** - For unit testing
  ```bash
  composer test
  ```

- **PHP CodeSniffer** - For coding standards (PSR-12)
  ```bash
  composer phpcs    # Check code style
  composer phpcbf   # Fix code style issues automatically
  ```

- **PHPStan** - For static analysis
  ```bash
  composer phpstan
  ```

## Documentation

Routes are defined and built using [Sunrise HTTP Router](https://github.com/sunrise-php/http-router), and Smarty extension details are available in the [Smarty documentation](https://www.smarty.net/docs/en/). Review those resources for deeper customization tips.

## Contributing

Contributions are welcome! Here's how you can contribute:

1. Fork the repository
2. Create a feature branch: `git checkout -b feature-name`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin feature-name`
5. Submit a pull request

Please make sure your code follows the PSR-12 coding standard and include tests for any new features or bug fixes.

If you find a bug or have a feature request, please create an issue in the [issue tracker](https://github.com/imponeer/smarty-sunrise-http-router/issues).
