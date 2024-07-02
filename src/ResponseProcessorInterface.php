<?php

namespace ITB\ShopwareStoreApiClient;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ResponseProcessorInterface
{
    /**
     * @template T of object
     * @param class-string<T> $type
     * @return T
     */
    public function processResponse(string $type, RequestInterface $request, ResponseInterface $response, int $expectedStatusCode): object;
}
