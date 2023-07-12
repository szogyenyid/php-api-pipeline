<?php

namespace Szogyenyid\PhpApiPipeline\Filters;

use GuzzleHttp\Psr7\Utils;
use Szogyenyid\PhpApiPipeline\Payload;
use Szogyenyid\PhpApiPipeline\ResponseException;

class Authenticate implements FilterInterface
{
    public function __invoke(Payload $payload): Payload
    {
        $request = json_decode($payload->getRequest()->getBody()->getContents(), true);
        if (!is_array($request)) {
            throw new ResponseException(
                $payload->getResponse()
                    ->withStatus(400)
                    ->withBody(Utils::streamFor('Bad Request'))
            );
        }
        if (!isset($request['key']) || $request['key'] !== 'secret') {
            throw new ResponseException(
                $payload->getResponse()
                    ->withStatus(401)
                    ->withBody(Utils::streamFor('Unauthorized'))
            );
        }
        $jsonData = json_encode([
            'message' => 'Hello World!'
        ]);
        return $payload->withResponse(
            $payload->getResponse()
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200)
                ->withBody(Utils::streamFor($jsonData))
        );
    }
}
