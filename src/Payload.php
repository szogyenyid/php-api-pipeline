<?php

namespace Szogyenyid\PhpApiPipeline;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Payload
{
    public function __construct(
        private RequestInterface $request,
        private ResponseInterface $response
    ) {
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    public function withRequest(RequestInterface $request): Payload
    {
        $payload = clone $this;
        $payload->request = $request;
        return $payload;
    }

    public function withResponse(ResponseInterface $response): Payload
    {
        $payload = clone $this;
        $payload->response = $response;
        return $payload;
    }
}
