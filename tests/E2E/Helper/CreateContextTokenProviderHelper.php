<?php

namespace ITB\ShopwareStoreApiClient\Tests\E2E\Helper;

use ITB\ShopwareStoreApiClient\Auth\AccessTokenProvider\WithStaticAccessToken;
use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider\WithAnonymousUser;
use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider\WithAuthenticatedUser;
use ITB\ShopwareStoreApiClient\RequestBuilder;
use ITB\ShopwareStoreApiClient\Tests\E2E\Service\RequestBuilderWithNonTransactionalHeader;
use Symfony\Component\HttpClient\Psr18Client;

final readonly class CreateContextTokenProviderHelper
{
    public static function createContextTokenProviderWithAnonymousUser(
        string $shopwareStoreUrl,
        string $shopwareStoreAccessToken
    ): WithAnonymousUser {
        $accessTokenProvider = new WithStaticAccessToken($shopwareStoreAccessToken);
        $requestBuilder = new RequestBuilder();
        $requestBuilderWithNonTransactionalHeader = new RequestBuilderWithNonTransactionalHeader($requestBuilder);
        $httpClient = new Psr18Client();

        return new WithAnonymousUser($shopwareStoreUrl, $accessTokenProvider, $requestBuilderWithNonTransactionalHeader, $httpClient);
    }

    public static function createContextTokenProviderWithAuthenticatedUser(
        string $shopwareStoreUrl,
        string $shopwareStoreAccessToken,
        string $username,
        string $password
    ): WithAuthenticatedUser {
        $accessTokenProvider = new WithStaticAccessToken($shopwareStoreAccessToken);
        $requestBuilder = new RequestBuilder();
        $requestBuilderWithNonTransactionalHeader = new RequestBuilderWithNonTransactionalHeader($requestBuilder);
        $httpClient = new Psr18Client();

        return new WithAuthenticatedUser(
            $shopwareStoreUrl,
            $accessTokenProvider,
            $username,
            $password,
            $requestBuilderWithNonTransactionalHeader,
            $httpClient
        );
    }
}
