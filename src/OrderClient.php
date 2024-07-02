<?php

namespace ITB\ShopwareStoreApiClient;

use ITB\ShopwareStoreApiClient\Auth\AccessTokenProvider;
use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;
use ITB\ShopwareStoreApiClient\Exception\RequestExceptionWithHttpClientException;
use ITB\ShopwareStoreApiClient\Exception\RequestExceptionWithHttpStatusCode;
use ITB\ShopwareStoreApiClient\Language\LanguageIdProvider;
use ITB\ShopwareStoreApiClient\Model\Order;
use ITB\ShopwareStoreApiClient\Model\Order\OrderState;
use ITB\ShopwareStoreApiClient\Request\Order\OrderMetadata;
use ITB\ShopwareStoreApiClient\Request\Order\PaymentInitialization;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

final readonly class OrderClient
{
    public function __construct(
        private string $shopwareStoreUrl,
        private RequestBuilderInterface $requestBuilder,
        private AccessTokenProvider $accessTokenProvider,
        private ClientInterface $httpClient,
        private ResponseProcessorInterface $responseProcessor,
    ) {
    }

    public function cancelOrder(
        string $orderId,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): OrderState {
        $request = $this->requestBuilder->buildRequest(
            'POST',
            $this->shopwareStoreUrl . '/store-api/order/state/cancel',
            [
                'orderId' => $orderId,
            ],
            $this->accessTokenProvider,
            $contextTokenProvider,
            $languageIdProvider,
        );

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new RequestExceptionWithHttpClientException($clientException, $request);
        }

        return $this->responseProcessor->processResponse(OrderState::class, $request, $response, 200);
    }

    public function createOrderFromCart(
        ?OrderMetadata $orderMetadata,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): Order {
        $request = $this->requestBuilder->buildRequest(
            'POST',
            $this->shopwareStoreUrl . '/store-api/checkout/order',
            $orderMetadata?->toPayload(),
            $this->accessTokenProvider,
            $contextTokenProvider,
            $languageIdProvider,
        );

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new RequestExceptionWithHttpClientException($clientException, $request);
        }

        return $this->responseProcessor->processResponse(Order::class, $request, $response, 200);
    }

    public function initializeOrderPayment(PaymentInitialization $data, ContextTokenProvider $contextTokenProvider): ?string
    {
        $request = $this->requestBuilder->buildRequest(
            'POST',
            $this->shopwareStoreUrl . '/store-api/handle-payment',
            $data->toPayload(),
            $this->accessTokenProvider,
            $contextTokenProvider,
            null,
        );

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new RequestExceptionWithHttpClientException($clientException, $request);
        }

        $content = $response->getBody()
            ->getContents();

        if ($response->getStatusCode() !== 200) {
            throw new RequestExceptionWithHttpStatusCode($response->getStatusCode(), 200, $request, $content);
        }

        $decodedResponse = json_decode($content, true);
        if (\is_array($decodedResponse) === false) {
            return null;
        }

        return $decodedResponse['redirectUrl'] ?? null;
    }

    public function updateOrderPaymentMethod(string $orderId, string $paymentMethodId, ContextTokenProvider $contextTokenProvider): void
    {
        $request = $this->requestBuilder->buildRequest(
            'POST',
            $this->shopwareStoreUrl . '/store-api/order/payment',
            [
                'orderId' => $orderId,
                'paymentMethodId' => $paymentMethodId,
            ],
            $this->accessTokenProvider,
            $contextTokenProvider,
            null,
        );

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new RequestExceptionWithHttpClientException($clientException, $request);
        }

        if ($response->getStatusCode() !== 200) {
            // TODO: throw exception
        }

        // TODO: check if response contains "success" => true
    }
}
