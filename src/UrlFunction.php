<?php

namespace Imponeer\Smarty\Extensions\SunriseHTTPRouter;

use Smarty\Exception;
use Smarty\FunctionHandler\FunctionHandlerInterface;
use Smarty\Template;
use Sunrise\Http\Router\RouterInterface;

/**
 * Defines smarty url function
 *
 * @package Imponeer\Smarty\Extensions\SunriseHTTPRouter
 */
class UrlFunction implements FunctionHandlerInterface
{
    /**
     * Url constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(
        private readonly RouterInterface $router
    ) {
    }

    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    public function handle($params, Template $template)
    {
        $attributes = (array)($params['attr'] ?? $params['attributes'] ?? []);

        if (!isset($params['name'])) {
            throw new Exception('name not set for url function');
        }

        $route = $this->router->getRoute($params['name']);

        return $this->router->buildRoute($route, $attributes);
    }

    public function isCacheable(): bool
    {
        return true;
    }
}
