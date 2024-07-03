<?php

namespace ITB\ShopwareStoreApiClient;

use ITB\ShopwareStoreApiClient\Auth\AccessTokenProvider;
use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;
use ITB\ShopwareStoreApiClient\Exception\RequestExceptionWithHttpClientException;
use ITB\ShopwareStoreApiClient\Exception\RequestExceptionWithHttpStatusCode;
use ITB\ShopwareStoreApiClient\Language\LanguageIdProvider;
use ITB\ShopwareStoreApiClient\Model\Cart\CustomerAddress;
use ITB\ShopwareStoreApiClient\Model\Cart\CustomerAddressCollection;
use ITB\ShopwareStoreApiClient\Request\Address\AddressData;
use ITB\ShopwareStoreApiClient\Request\SearchCriteria;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

final readonly class AddressClient
{
    public function __construct(
        private string $shopwareStoreUrl,
        private RequestBuilderInterface $requestBuilder,
        private AccessTokenProvider $accessTokenProvider,
        private ClientInterface $httpClient,
        private ResponseProcessorInterface $responseProcessor,
    ) {
    }

    public function changeCustomerDefaultBillingAddress(
        string $addressId,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): void {
        $request = $this->requestBuilder->buildRequest(
            'PATCH',
            $this->shopwareStoreUrl . '/store-api/account/address/default-billing/' . $addressId,
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

        if ($response->getStatusCode() !== 204) {
            throw new RequestExceptionWithHttpStatusCode($response->getStatusCode(), 204, $request, $response->getBody());
        }
    }

    public function changeCustomerDefaultShippingAddress(
        string $addressId,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): void {
        $request = $this->requestBuilder->buildRequest(
            'PATCH',
            $this->shopwareStoreUrl . '/store-api/account/address/default-shipping/' . $addressId,
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

        if ($response->getStatusCode() !== 204) {
            throw new RequestExceptionWithHttpStatusCode($response->getStatusCode(), 204, $request, $response->getBody());
        }
    }

    public function createCustomerAddress(
        AddressData $data,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): CustomerAddress {
        $request = $this->requestBuilder->buildRequest(
            'POST',
            $this->shopwareStoreUrl . '/store-api/account/address',
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

        return $this->responseProcessor->processResponse(CustomerAddress::class, $request, $response, 200);
    }

    public function deleteCustomerAddress(
        string $addressId,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): void {
        $request = $this->requestBuilder->buildRequest(
            'DELETE',
            $this->shopwareStoreUrl . '/store-api/account/address/' . $addressId,
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

        if ($response->getStatusCode() !== 204) {
            throw new RequestExceptionWithHttpStatusCode($response->getStatusCode(), 200, $request, $response->getBody());
        }
    }

    public function fetchCustomerAddresses(
        SearchCriteria $criteria,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): CustomerAddressCollection {
        $request = $this->requestBuilder->buildRequest(
            'POST',
            $this->shopwareStoreUrl . '/store-api/account/list-address',
            $criteria->toPayload(),
            $this->accessTokenProvider,
            $contextTokenProvider,
            $languageIdProvider,
        );

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new RequestExceptionWithHttpClientException($clientException, $request);
        }

        return $this->responseProcessor->processResponse(CustomerAddressCollection::class, $request, $response, 200);
    }

    public function updateCustomerAddress(
        string $addressId,
        AddressData $data,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): CustomerAddress {
        $payload = $data->toPayload();
        $payload['id'] = $addressId;

        $request = $this->requestBuilder->buildRequest(
            'PATCH',
            $this->shopwareStoreUrl . '/store-api/account/address/' . $addressId,
            $payload,
            $this->accessTokenProvider,
            $contextTokenProvider,
            $languageIdProvider,
        );

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new RequestExceptionWithHttpClientException($clientException, $request);
        }

        return $this->responseProcessor->processResponse(CustomerAddress::class, $request, $response, 200);
    }
}
