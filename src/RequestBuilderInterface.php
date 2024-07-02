<?php

namespace ITB\ShopwareStoreApiClient;

use ITB\ShopwareStoreApiClient\Auth\AccessTokenProvider;
use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;
use ITB\ShopwareStoreApiClient\Language\LanguageIdProvider;
use Psr\Http\Message\RequestInterface;

interface RequestBuilderInterface
{
    /**
     * @param array<int|string, mixed>|null $data
     */
    public function buildRequest(
        string $httpMethod,
        string $url,
        ?array $data,
        AccessTokenProvider $accessTokenProvider,
        ?ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): RequestInterface;
}
