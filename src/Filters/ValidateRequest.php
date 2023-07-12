<?php

namespace Szogyenyid\PhpApiPipeline\Filters;

use GuzzleHttp\Psr7\Utils;
use Rakit\Validation\Validator;
use Szogyenyid\PhpApiPipeline\Payload;
use Szogyenyid\PhpApiPipeline\ResponseException;

class ValidateRequest implements FilterInterface
{
    public function __invoke(Payload $payload): Payload
    {
        $requestBody = json_decode($payload->getRequest()->getBody()->getContents(), true);
        if (!is_array($requestBody)) {
            throw new ResponseException(
                $payload->getResponse()
                    ->withStatus(400)
                    ->withBody(Utils::streamFor('Invalid JSON'))
            );
        }
        $validation = (new Validator())->validate($requestBody, [
            'key' => 'required',
        ]);
        if ($validation->fails()) {
            throw new ResponseException(
                $payload->getResponse()
                    ->withStatus(400)
                    ->withBody(Utils::streamFor(implode(',', $validation->errors()->firstOfAll())))
            );
        }
        return $payload;
    }
}
