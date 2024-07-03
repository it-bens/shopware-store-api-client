<?php

namespace ITB\ShopwareStoreApiClient;

use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;
use ITB\ShopwareStoreApiClient\Language\LanguageIdProvider;
use ITB\ShopwareStoreApiClient\Model\Cart\OrderCollection;
use ITB\ShopwareStoreApiClient\Model\Order;
use ITB\ShopwareStoreApiClient\Model\Order\OrderState;
use ITB\ShopwareStoreApiClient\Request\Order\OrderMetadata;
use ITB\ShopwareStoreApiClient\Request\Order\PaymentInitialization;
use ITB\ShopwareStoreApiClient\Request\SearchCriteria;

interface OrderClientInterface
{
    public function cancelOrder(
        string $orderId,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): OrderState;

    public function createOrderFromCart(
        ?OrderMetadata $orderMetadata,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): Order;

    public function fetchOrders(
        SearchCriteria $criteria,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): OrderCollection;

    public function initializeOrderPayment(PaymentInitialization $data, ContextTokenProvider $contextTokenProvider): ?string;

    public function updateOrderPaymentMethod(string $orderId, string $paymentMethodId, ContextTokenProvider $contextTokenProvider): void;
}
