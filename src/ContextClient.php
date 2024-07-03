<?php

namespace ITB\ShopwareStoreApiClient;

use ITB\ShopwareStoreApiClient\Auth\AccessTokenProvider;
use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;
use ITB\ShopwareStoreApiClient\Exception\RequestExceptionWithHttpClientException;
use ITB\ShopwareStoreApiClient\Exception\RequestExceptionWithHttpStatusCode;
use ITB\ShopwareStoreApiClient\Language\LanguageIdProvider;
use ITB\ShopwareStoreApiClient\Model\Context;
use ITB\ShopwareStoreApiClient\Request\Context\ContextData;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

final readonly class ContextClient implements ContextClientInterface
{
    public function __construct(
        private string $shopwareStoreUrl,
        private RequestBuilderInterface $requestBuilder,
        private AccessTokenProvider $accessTokenProvider,
        private ClientInterface $httpClient,
        private ResponseProcessorInterface $responseProcessor,
    ) {
    }

    public function fetchCurrentContext(ContextTokenProvider $contextTokenProvider, ?LanguageIdProvider $languageIdProvider): Context
    {
        $request = $this->requestBuilder->buildRequest(
            'GET',
            $this->shopwareStoreUrl . '/store-api/context',
            null,
            $this->accessTokenProvider,
            $contextTokenProvider,
            $languageIdProvider,
        );

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new RequestExceptionWithHttpClientException($clientException, $request);
        }

        return $this->responseProcessor->processResponse(Context::class, $request, $response, 200);
    }

    public function updateCurrentContext(
        ContextData $data,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): void {
        $request = $this->requestBuilder->buildRequest(
            'PATCH',
            $this->shopwareStoreUrl . '/store-api/context',
            $data->toPayload(),
            $this->accessTokenProvider,
            $contextTokenProvider,
            $languageIdProvider,
        );

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new RequestExceptionWithHttpClientException($clientException, $request);
        }

        if ($response->getStatusCode() !== 200) {
            throw new RequestExceptionWithHttpStatusCode($response->getStatusCode(), 200, $request, $response->getBody());
        }
    }
}
