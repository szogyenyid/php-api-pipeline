<?php

namespace Szogyenyid\PhpApiPipeline\Filters;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Szogyenyid\PhpApiPipeline\FilterInterface;
use Szogyenyid\PhpApiPipeline\Payload;
use Szogyenyid\PhpApiPipeline\ResponseException;
use Szogyenyid\PhpApiPipeline\RouteHandlers\MyHandler;

use function FastRoute\simpleDispatcher;

class Route implements FilterInterface
{
    private function getDispatcher(RequestInterface $request, ResponseInterface $response): Dispatcher
    {
        return simpleDispatcher(function (RouteCollector $r) use ($request, $response) {
            $r->get('/hello[/{name}]', [(new MyHandler($request, $response)), 'hello']);
            $r->get('/reverse/{string}', [(new MyHandler($request, $response)), 'reverse']);
        });
    }
    public function __invoke(Payload $payload): Payload
    {
        $dispatcher = $this->getDispatcher($payload->getRequest(), $payload->getResponse());
        $routeInfo = $dispatcher->dispatch(
            $payload->getRequest()->getMethod(),
            $payload->getRequest()->getUri()->getPath()
        );
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                throw new ResponseException(
                    $payload->getResponse()
                        ->withStatus(404)
                        ->withBody(Utils::streamFor('Not Found'))
                );
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                throw new ResponseException(
                    $payload->getResponse()
                        ->withStatus(405)
                        ->withBody(Utils::streamFor('Method Not Allowed'))
                );
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                return $payload->withResponse(
                    $handler(...$vars)
                );
        }
    }
}
