<?php

namespace Szogyenyid\PhpApiPipeline\Handlers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractHandler
{
    public function __construct(
        protected RequestInterface $request,
        protected ResponseInterface $response
    ) {
    }
}
