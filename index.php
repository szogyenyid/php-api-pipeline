<?php

use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\ServerRequest;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Pipeline\Pipeline;
use Szogyenyid\PhpApiPipeline\Filters\Authenticate;
use Szogyenyid\PhpApiPipeline\Filters\EmitResponse;
use Szogyenyid\PhpApiPipeline\Filters\Route;
use Szogyenyid\PhpApiPipeline\Payload;
use Szogyenyid\PhpApiPipeline\ResponseException;

require __DIR__ . '/vendor/autoload.php';

$payload = new Payload(
    request: ServerRequest::fromGlobals(),
    response: (new HttpFactory())->createResponse()
);

try {
    (new Pipeline())
    ->pipe(new Authenticate())
    ->pipe(new Route())
    ->pipe(new EmitResponse())
    ->process($payload);
} catch (ResponseException $e) {
    $response = $e->getResponse();
    (new SapiEmitter())->emit($response);
}
