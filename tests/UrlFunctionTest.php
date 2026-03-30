<?php

namespace Imponeer\Smarty\Extensions\SunriseHTTPRouter\Tests;

use Imponeer\Smarty\Extensions\SunriseHTTPRouter\SunriseHttpRouterExtension;
use PHPUnit\Framework\TestCase;
use Smarty\Smarty;
use Sunrise\Http\Router\Loader\LoaderInterface;
use Sunrise\Http\Router\ReferenceResolver;
use Sunrise\Http\Router\Route;
use Sunrise\Http\Router\Router;
use Sunrise\Http\Router\RouterInterface;

class UrlFunctionTest extends TestCase
{
    private SunriseHttpRouterExtension $extension;
    private Smarty $smarty;

    protected function setUp(): void
    {
        $router = $this->createRouterWithRoutes(
            new Route('home', '/', static fn() => 'test', methods: ['GET']),
            new Route('test', '/test/{a}', static fn() => 'test 2', methods: ['GET'])
        );

        $this->extension = new SunriseHttpRouterExtension($router);

        $this->smarty = new Smarty();
        $this->smarty->caching = Smarty::CACHING_OFF;
        $this->smarty->addExtension($this->extension);

        parent::setUp();
    }

    private function createRouterWithRoutes(Route ...$routes): RouterInterface
    {
        $loader = new class ($routes) implements LoaderInterface {
            /**
             * @param array<Route> $routes
             */
            public function __construct(private array $routes)
            {
            }

            public function load(): iterable
            {
                foreach ($this->routes as $route) {
                    yield $route->getName() => $route;
                }
            }
        };

        return new Router(ReferenceResolver::build(), [$loader]);
    }

    public function testGetFunctionHandlerReturnsUrlFunction(): void
    {
        $handler = $this->extension->getFunctionHandler('url');

        $this->assertIsObject($handler);
        $this->assertSame($handler, $this->extension->getFunctionHandler('url'));
        $this->assertNull($this->extension->getFunctionHandler('unknown'));
    }

    public function testInvokingWithCorrectAttributes(): void
    {
        $src = urlencode('{url name="test" attributes=["a" => "b"]}');
        $ret = $this->smarty->fetch('eval:urlencode:' . $src);
        $this->assertSame('/test/b', $ret);
    }

    public function testInvokingWithIncorrectAttributes(): void
    {
        $src = urlencode('{url name="test" attributes=["b" => "x"]}');

        $this->expectException(\InvalidArgumentException::class);
        $this->smarty->fetch('eval:urlencode:' . $src);
    }

    public function testInvokingWithoutAttributes(): void
    {
        $src = urlencode('{url name="home"}');
        $ret = $this->smarty->fetch('eval:urlencode:' . $src);
        $this->assertSame('/', $ret);
    }

    public function testInvokingWithInvalidRouteName(): void
    {
        $src = urlencode('{url name="home2"}');

        $this->expectException(\InvalidArgumentException::class);
        $this->smarty->fetch('eval:urlencode:' . $src);
    }
}
