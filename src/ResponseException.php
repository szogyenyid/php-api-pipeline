<?php

namespace Szogyenyid\PhpApiPipeline;

use Exception;
use Psr\Http\Message\ResponseInterface;

class ResponseException extends Exception
{
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
        parent::__construct();
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
