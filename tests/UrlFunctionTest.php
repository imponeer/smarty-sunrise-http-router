<?php

use Imponeer\Smarty\Extensions\SunriseHTTPRouter\UrlFunction;
use PHPUnit\Framework\TestCase;
use Sunrise\Http\Router\Exception\MissingAttributeValueException;
use Sunrise\Http\Router\Exception\RouteNotFoundException;
use Sunrise\Http\Router\Route;
use Sunrise\Http\Router\RouteCollector;
use Sunrise\Http\Router\Router;

class UrlFunctionTest extends TestCase
{
    /**
     * @var UrlFunction
     */
    private $plugin;
    /**
     * @var Smarty
     */
    private $smarty;

    protected function setUp(): void
    {
        $collector = new RouteCollector();
        $collector->get("home", "/", function ($request) {
            return "test";
        });
        $collector->get("test", "/test/{a}", function ($request) {
            return "test 2";
        });

        $router = new Router();
        $router->addRoute(
            ...$collector->getCollection()->all()
        );

        $this->plugin = new UrlFunction($router);

        $this->smarty = new Smarty();
        $this->smarty->caching = Smarty::CACHING_OFF;
        $this->smarty->registerPlugin(
            'function',
            $this->plugin->getName(),
            [$this->plugin, 'execute']
        );

        parent::setUp();
    }

    public function testGetName() {
        $this->assertSame('url', $this->plugin->getName());
    }

    public function testInvokingWithCorrectAttributes() {
        $src = urlencode('{url name="test" attributes=["a" => "b"]}');
        $ret = $this->smarty->fetch('eval:urlencode:'.$src);
        $this->assertSame("/test/b", $ret);
    }

    /**
     * @fail
     */
    public function testInvokingWithIncorrectAttributes() {
        $src = urlencode('{url name="test" attributes=["b" => "x"]}');

        $this->expectException(MissingAttributeValueException::class);
        $this->smarty->fetch('eval:urlencode:'.$src);
    }

    public function testInvokingWithoutAttributes() {
        $src = urlencode('{url name="home"}');
        $ret = $this->smarty->fetch('eval:urlencode:'.$src);
        $this->assertSame("/", $ret);
    }

    public function testInvokingWithInvalidRouteName() {
        $src = urlencode('{url name="home2"}');

        $this->expectException(RouteNotFoundException::class);
        $this->smarty->fetch('eval:urlencode:'.$src);
    }

}