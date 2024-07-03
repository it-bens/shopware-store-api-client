<?php

namespace ITB\ShopwareStoreApiClient;

use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;
use ITB\ShopwareStoreApiClient\Language\LanguageIdProvider;
use ITB\ShopwareStoreApiClient\Model\Cart;
use ITB\ShopwareStoreApiClient\Request\Cart\LineItem\LineItemCollection;

interface CartClientInterface
{
    public function addLineItemsToCart(
        LineItemCollection $lineItems,
        ?ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): Cart;

    public function deleteCart(?ContextTokenProvider $contextTokenProvider): void;

    public function deleteProductFromCartByProductId(
        LineItemCollection $lineItems,
        ?ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): Cart;

    public function fetchOrCreateCart(?ContextTokenProvider $contextTokenProvider, ?LanguageIdProvider $languageIdProvider): Cart;

    public function updateLineItemsInCart(
        LineItemCollection $lineItems,
        ?ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): Cart;
}
