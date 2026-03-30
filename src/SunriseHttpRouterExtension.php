<?php

namespace Imponeer\Smarty\Extensions\SunriseHTTPRouter;

use Smarty\Extension\Base;
use Smarty\FunctionHandler\FunctionHandlerInterface;
use Sunrise\Http\Router\RouterInterface;

/**
 * Smarty extension that exposes Sunrise HTTP Router helpers.
 */
class SunriseHttpRouterExtension extends Base
{
    private readonly UrlFunction $urlFunction;

    public function __construct(RouterInterface $router)
    {
        $this->urlFunction = new UrlFunction($router);
    }

    public function getFunctionHandler(string $functionName): ?FunctionHandlerInterface
    {
        return match ($functionName) {
            'url' => $this->urlFunction,
            default => null
        };
    }
}
