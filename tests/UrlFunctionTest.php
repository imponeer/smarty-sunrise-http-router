<?php

use Imponeer\Smarty\Extensions\SunriseHTTPRouter\UrlFunction;
use PHPUnit\Framework\TestCase;
use Sunrise\Http\Router\Exception\InvalidRouteBuildingValueException;
use Sunrise\Http\Router\Exception\NoRouteFoundException;
use Sunrise\Http\Router\Route;
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
        $router = new Sunrise\Http\Router\Router();
        $router->addRoute(
            new Route("home", "/", function ($request) {
                return "test";
            }, [
                "GET"
            ]),
            new Route("test",  "/test/{a}", function ($request) {
                return "test 2";
            }, [
                "GET"
            ]),
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

        $this->expectException(InvalidRouteBuildingValueException::class);
        $this->smarty->fetch('eval:urlencode:'.$src);
    }

    public function testInvokingWithoutAttributes() {
        $src = urlencode('{url name="home"}');
        $ret = $this->smarty->fetch('eval:urlencode:'.$src);
        $this->assertSame("/", $ret);
    }

    public function testInvokingWithInvalidRouteName() {
        $src = urlencode('{url name="home2"}');

        $this->expectException(NoRouteFoundException::class);
        $this->smarty->fetch('eval:urlencode:'.$src);
    }

}