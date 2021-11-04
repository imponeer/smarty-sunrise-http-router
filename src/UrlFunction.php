<?php

namespace Imponeer\Smarty\Extensions\SunriseHTTPRouter;

use Imponeer\Contracts\Smarty\Extension\SmartyFunctionInterface;
use Smarty_Internal_Template;
use SmartyException;
use Sunrise\Http\Router\Router;

/**
 * Defines smarty url function
 *
 * @package Imponeer\Smarty\Extensions\SunriseHTTPRouter
 */
class UrlFunction implements SmartyFunctionInterface
{
    /**
     * @var Router
     */
    private $router;

    /**
     * Url constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'url';
    }

    /**
     * @inheritDoc
     *
     * @throws SmartyException
     */
    public function execute($params, Smarty_Internal_Template &$template)
    {
        $attributes = [];
        if (isset($params['attr'])) {
            $attributes = (array)$params['attr'];
        } elseif (isset($params['attributes'])) {
            $attributes = (array)$params['attributes'];
        }

        if (!isset($params['name'])) {
            throw new SmartyException('name not set for url function');
        }

        return $this->router->generateUri($params['name'], $attributes);
    }
}