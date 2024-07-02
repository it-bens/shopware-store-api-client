<?php

namespace ITB\ShopwareStoreApiClient\Tests\E2E\Helper;

use ITB\ShopwareStoreApiClient\Auth\AccessTokenProvider\WithStaticAccessToken;
use ITB\ShopwareStoreApiClient\OrderClient;
use ITB\ShopwareStoreApiClient\RequestBuilder;
use ITB\ShopwareStoreApiClient\Tests\E2E\Service\RequestBuilderWithNonTransactionalHeader;
use Symfony\Component\HttpClient\Psr18Client;

final readonly class CreateOrderClientHelper
{
    public static function createOrderClient(string $shopwareStoreUrl, string $shopwareStoreAccessToken): OrderClient
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilderWithNonTransactionalHeader = new RequestBuilderWithNonTransactionalHeader($requestBuilder);
        $accessTokenProvider = new WithStaticAccessToken($shopwareStoreAccessToken);
        $httpClient = new Psr18Client();
        $responseProcessor = CreateResponseProcessorHelper::createResponseProcessor();

        return new OrderClient(
            $shopwareStoreUrl,
            $requestBuilderWithNonTransactionalHeader,
            $accessTokenProvider,
            $httpClient,
            $responseProcessor
        );
    }
}
