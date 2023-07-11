<?php

namespace Szogyenyid\PhpApiPipeline;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Payload
{
    public function __construct(
        public RequestInterface &$request,
        public ResponseInterface &$response
    ) {
    }
}
