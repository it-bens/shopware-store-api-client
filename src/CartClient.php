<?php

namespace ITB\ShopwareStoreApiClient;

use ITB\ShopwareStoreApiClient\Auth\AccessTokenProvider;
use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;
use ITB\ShopwareStoreApiClient\Exception\RequestExceptionWithHttpClientException;
use ITB\ShopwareStoreApiClient\Exception\RequestExceptionWithHttpStatusCode;
use ITB\ShopwareStoreApiClient\Language\LanguageIdProvider;
use ITB\ShopwareStoreApiClient\Model\Cart;
use ITB\ShopwareStoreApiClient\Request\Cart\LineItem\LineItemCollection;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

final readonly class CartClient implements CartClientInterface
{
    public function __construct(
        private string $shopwareStoreUrl,
        private RequestBuilderInterface $requestBuilder,
        private AccessTokenProvider $accessTokenProvider,
        private ClientInterface $httpClient,
        private ResponseProcessorInterface $responseProcessor,
    ) {
    }

    public function addLineItemsToCart(
        LineItemCollection $lineItems,
        ?ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): Cart {
        $request = $this->requestBuilder->buildRequest(
            'POST',
            $this->shopwareStoreUrl . '/store-api/checkout/cart/line-item',
            $lineItems->toPayload(),
            $this->accessTokenProvider,
            $contextTokenProvider,
            $languageIdProvider,
        );

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new RequestExceptionWithHttpClientException($clientException, $request);
        }

        return $this->responseProcessor->processResponse(Cart::class, $request, $response, 200);
    }

    public function deleteCart(?ContextTokenProvider $contextTokenProvider): void
    {
        $request = $this->requestBuilder->buildRequest(
            'DELETE',
            $this->shopwareStoreUrl . '/store-api/checkout/cart',
            null,
            $this->accessTokenProvider,
            $contextTokenProvider,
            null,
        );

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new RequestExceptionWithHttpClientException($clientException, $request);
        }

        if ($response->getStatusCode() !== 204) {
            throw new RequestExceptionWithHttpStatusCode($response->getStatusCode(), 204, $request, $response->getBody());
        }
    }

    public function deleteProductFromCartByProductId(
        LineItemCollection $lineItems,
        ?ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): Cart {
        if ($lineItems->allLineItemsHaveIds() === false) {
            throw new \RuntimeException('All line items must have an ID');
        }

        $request = $this->requestBuilder->buildRequest(
            'POST',
            $this->shopwareStoreUrl . '/store-api/checkout/cart/line-item/delete',
            $lineItems->toIdsPayload(),
            $this->accessTokenProvider,
            $contextTokenProvider,
            $languageIdProvider,
        );

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new RequestExceptionWithHttpClientException($clientException, $request);
        }

        return $this->responseProcessor->processResponse(Cart::class, $request, $response, 200);
    }

    public function fetchOrCreateCart(?ContextTokenProvider $contextTokenProvider, ?LanguageIdProvider $languageIdProvider): Cart
    {
        $request = $this->requestBuilder->buildRequest(
            'GET',
            $this->shopwareStoreUrl . '/store-api/checkout/cart',
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

        return $this->responseProcessor->processResponse(Cart::class, $request, $response, 200);
    }

    public function updateLineItemsInCart(
        LineItemCollection $lineItems,
        ?ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): Cart {
        if ($lineItems->allLineItemsHaveIds() === false) {
            throw new \RuntimeException('All line items must have an ID');
        }

        $request = $this->requestBuilder->buildRequest(
            'PATCH',
            $this->shopwareStoreUrl . '/store-api/checkout/cart/line-item',
            $lineItems->toPayload(),
            $this->accessTokenProvider,
            $contextTokenProvider,
            $languageIdProvider,
        );

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new RequestExceptionWithHttpClientException($clientException, $request);
        }

        return $this->responseProcessor->processResponse(Cart::class, $request, $response, 200);
    }
}
