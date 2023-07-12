<?php

namespace Szogyenyid\PhpApiPipeline;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Payload implements ContainerInterface
{
    /**
     *
     * @var array<string,mixed>
     */
    private array $attributes = [];

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

    public function has(string $id): bool
    {
        return isset($this->attributes[$id]);
    }

    public function get(string $id): mixed
    {
        if ($id == "request") {
            return $this->request;
        }
        if ($id == "response") {
            return $this->response;
        }
        return $this->attributes[$id] ?? null;
    }

    public function set(string $id, mixed $value): void
    {
        if ($id == "response" && $value instanceof ResponseInterface) {
            $this->response = $value;
            return;
        }
        $this->attributes[$id] = $value;
    }
}
