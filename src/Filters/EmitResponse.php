<?php

namespace Szogyenyid\PhpApiPipeline\Filters;

use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Szogyenyid\PhpApiPipeline\FilterInterface;
use Szogyenyid\PhpApiPipeline\Payload;

class EmitResponse implements FilterInterface
{
    public function __invoke(Payload $payload): Payload
    {
        (new SapiEmitter())->emit($payload->response);
        return $payload;
    }
}
