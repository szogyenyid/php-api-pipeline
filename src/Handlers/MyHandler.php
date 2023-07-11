<?php

namespace Szogyenyid\PhpApiPipeline\Handlers;

use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\ResponseInterface;

class MyHandler extends AbstractHandler
{
    public function hello(?string $name = null): ResponseInterface
    {
        return $this->response->withBody(Utils::streamFor(json_encode([
            'message' => 'Hello ' . ($name ?? 'World') . '!'
        ])));
    }

    public function reverse(string $string): ResponseInterface
    {
        return $this->response->withBody(Utils::streamFor(json_encode([
            'message' => strrev($string)
        ])));
    }
}
