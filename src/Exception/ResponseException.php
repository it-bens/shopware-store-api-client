<?php

namespace ITB\ShopwareStoreApiClient\Exception;

use Psr\Http\Message\ResponseInterface;

interface ResponseException
{
    public function getContent(): string;

    public function getResponse(): ResponseInterface;
}
