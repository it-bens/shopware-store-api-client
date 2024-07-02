<?php

namespace ITB\ShopwareStoreApiClient\Tests\E2E\Service;

use ITB\ShopwareStoreApiClient\Auth\AccessTokenProvider;
use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;
use ITB\ShopwareStoreApiClient\Language\LanguageIdProvider;
use ITB\ShopwareStoreApiClient\RequestBuilder;
use ITB\ShopwareStoreApiClient\RequestBuilderInterface;
use Psr\Http\Message\RequestInterface;

final readonly class RequestBuilderWithNonTransactionalHeader implements RequestBuilderInterface
{
    public function __construct(
        public RequestBuilder $decorated
    ) {
    }

    public function buildRequest(
        string $httpMethod,
        string $url,
        ?array $data,
        AccessTokenProvider $accessTokenProvider,
        ?ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): RequestInterface {
        $request = $this->decorated->buildRequest(
            $httpMethod,
            $url,
            $data,
            $accessTokenProvider,
            $contextTokenProvider,
            $languageIdProvider
        );

        return $request->withAddedHeader('sw-remote-api-test-runner-transactional', 'false');
    }
}
