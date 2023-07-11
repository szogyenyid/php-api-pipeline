<?php

namespace Szogyenyid\PhpApiPipeline;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
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
        $dispatcher = $this->getDispatcher($payload->request, $payload->response);
        $routeInfo = $dispatcher->dispatch($payload->request->getMethod(), $payload->request->getUri()->getPath());
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                throw new ResponseException(
                    $payload->response->withStatus(404)->withBody(Utils::streamFor('Not Found'))
                );
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                // ... 405 Method Not Allowed
                throw new ResponseException(
                    $payload->response->withStatus(405)->withBody(Utils::streamFor('Method Not Allowed'))
                );
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                $payload->response = $handler($vars);
                break;
        }
        return $payload;
    }
}
