<?php

namespace ITB\ShopwareStoreApiClient\Auth\AccessTokenProvider;

use ITB\ShopwareStoreApiClient\Auth\AccessToken;
use ITB\ShopwareStoreApiClient\Auth\AccessTokenProvider;

final readonly class WithStaticAccessToken implements AccessTokenProvider
{
    public function __construct(
        private string $accessToken
    ) {
    }

    public function provideAccessToken(): AccessToken
    {
        return new AccessToken($this->accessToken);
    }
}
