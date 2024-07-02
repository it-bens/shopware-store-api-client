<?php

namespace ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;

use ITB\ShopwareStoreApiClient\Auth\AccessTokenProvider;
use ITB\ShopwareStoreApiClient\Auth\ContextToken;
use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;
use ITB\ShopwareStoreApiClient\Exception\RequestExceptionWithHttpClientException;
use ITB\ShopwareStoreApiClient\Exception\RequestExceptionWithHttpStatusCode;
use ITB\ShopwareStoreApiClient\RequestBuilderInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

final class WithAuthenticatedUser implements ContextTokenProvider
{
    private ?ContextToken $contextToken = null;

    public function __construct(
        private readonly string $shopwareStoreUrl,
        private readonly AccessTokenProvider $accessTokenProvider,
        private readonly string $username,
        private readonly string $password,
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
            'POST',
            $this->shopwareStoreUrl . '/store-api/account/login',
            [
                'username' => $this->username,
                'password' => $this->password,
            ],
            $this->accessTokenProvider,
            null,
            null,
        );

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new RequestExceptionWithHttpClientException($clientException, $request);
        }

        $content = $response->getBody()
            ->getContents();

        if ($response->getStatusCode() === 200) {
            $contextTokenHeaders = $response->getHeader('sw-context-token');
            if ($contextTokenHeaders === []) {
                throw new \RuntimeException('No context token found in response');
            }

            /** @var string $contextTokenHeader */
            $contextTokenHeader = reset($contextTokenHeaders);
            $this->contextToken = new ContextToken($contextTokenHeader);

            return $this->contextToken;
        }

        throw new RequestExceptionWithHttpStatusCode($response->getStatusCode(), 200, $request, $content);
    }

    public function resetContextToken(): void
    {
        $this->contextToken = null;
    }
}
