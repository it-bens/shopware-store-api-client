<?php

namespace ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;

use ITB\ShopwareStoreApiClient\Auth\AccessTokenProvider;
use ITB\ShopwareStoreApiClient\Auth\ContextToken;
use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;
use ITB\ShopwareStoreApiClient\RequestBuilderInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

final class WithAnonymousUser implements ContextTokenProvider
{
    private ?ContextToken $contextToken = null;

    public function __construct(
        private readonly string $shopwareStoreUrl,
        private readonly AccessTokenProvider $accessTokenProvider,
        private readonly RequestBuilderInterface $requestBuilder,
        private readonly ClientInterface $httpClient,
    ) {
    }

    public function provideContextToken(): ContextToken
    {
        if ($this->contextToken instanceof ContextToken) {
            return $this->contextToken;
        }

        $request = $this->requestBuilder->buildRequest(
            'GET',
            $this->shopwareStoreUrl . '/store-api/context',
            null,
            $this->accessTokenProvider,
            null,
            null
        );

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new \RuntimeException('Failed to fetch context token', 0, $clientException);
        }

        $contextTokenHeaders = $response->getHeader('sw-context-token');
        if ($contextTokenHeaders === []) {
            throw new \RuntimeException('No context token found in response');
        }

        /** @var string $contextTokenHeader */
        $contextTokenHeader = reset($contextTokenHeaders);
        $this->contextToken = new ContextToken($contextTokenHeader);

        return $this->contextToken;
    }

    public function resetContextToken(): void
    {
        $this->contextToken = null;
    }
}
