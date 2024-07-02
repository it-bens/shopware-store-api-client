<?php

namespace ITB\ShopwareStoreApiClient\Exception;

use Psr\Http\Message\RequestInterface;

interface RequestExceptionInterface extends \Throwable
{
    public function getRequest(): RequestInterface;
}
