<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart;

use ITB\ShopwareStoreApiClient\Model\Order;

final readonly class OrderCollection
{
    /**
     * @param Order[] $elements
     */
    public function __construct(
        public array $elements
    ) {
    }
}
