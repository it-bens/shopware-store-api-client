<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart;

use ITB\ShopwareStoreApiClient\Model\Common\CalculatedPrice;

final readonly class Transaction
{
    public function __construct(
        public string $paymentMethodId,
        public CalculatedPrice $amount,
    ) {
    }
}
