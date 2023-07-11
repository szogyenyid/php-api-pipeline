<?php

namespace Szogyenyid\PhpApiPipeline\Filters;

use Szogyenyid\PhpApiPipeline\Payload;

interface FilterInterface
{
    public function __invoke(Payload $payload): Payload;
}
