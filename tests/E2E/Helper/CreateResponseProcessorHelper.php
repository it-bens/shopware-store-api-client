<?php

namespace ITB\ShopwareStoreApiClient\Tests\E2E\Helper;

use ITB\ShopwareStoreApiClient\ResponseProcessor;

final readonly class CreateResponseProcessorHelper
{
    public static function createResponseProcessor(): ResponseProcessor
    {
        $serializer = CreateSerializerHelper::createSerializer();

        return new ResponseProcessor($serializer);
    }
}
