<?php

namespace Szogyenyid\PhpApiPipeline\Filters;

use GuzzleHttp\Psr7\Utils;
use Szogyenyid\PhpApiPipeline\FilterInterface;
use Szogyenyid\PhpApiPipeline\Payload;
use Szogyenyid\PhpApiPipeline\ResponseException;

class Authenticate implements FilterInterface
{
    public function __invoke(Payload $payload): Payload
    {
        $request = json_decode($payload->request->getBody()->getContents(), true);
        if ($request['key'] !== 'secret') {
            $response = $payload->response
                ->withStatus(401)
                ->withBody(Utils::streamFor('Unauthorized'));
            throw new ResponseException($response);
        }
        $jsonData = json_encode([
            'message' => 'Hello World!'
        ]);
        $payload->response = $payload->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200)
            ->withBody(Utils::streamFor($jsonData));
        return $payload;
    }
}
