<?php

namespace Szogyenyid\PhpApiPipeline;

interface FilterInterface
{
    public function __invoke(Payload $payload);
}
