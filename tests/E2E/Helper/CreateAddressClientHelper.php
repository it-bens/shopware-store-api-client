<?php

namespace ITB\ShopwareStoreApiClient\Tests\E2E\Helper;

use ITB\ShopwareStoreApiClient\AddressClient;
use ITB\ShopwareStoreApiClient\Auth\AccessTokenProvider\WithStaticAccessToken;
use ITB\ShopwareStoreApiClient\RequestBuilder;
use ITB\ShopwareStoreApiClient\Tests\E2E\Service\RequestBuilderWithNonTransactionalHeader;
use Symfony\Component\HttpClient\Psr18Client;

final readonly class CreateAddressClientHelper
{
    public static function createAddressClient(string $shopwareStoreUrl, string $shopwareStoreAccessToken): AddressClient
    {
        $requestBuilder = new RequestBuilder();
        $requestBuilderWithNonTransactionalHeader = new RequestBuilderWithNonTransactionalHeader($requestBuilder);
        $accessTokenProvider = new WithStaticAccessToken($shopwareStoreAccessToken);
        $httpClient = new Psr18Client();
        $responseProcessor = CreateResponseProcessorHelper::createResponseProcessor();

        return new AddressClient(
            $shopwareStoreUrl,
            $requestBuilderWithNonTransactionalHeader,
            $accessTokenProvider,
            $httpClient,
            $responseProcessor
        );
    }
}
