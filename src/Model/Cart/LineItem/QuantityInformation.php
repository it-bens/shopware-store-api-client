<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart\LineItem;

final readonly class QuantityInformation
{
    public function __construct(
        public int $minPurchase,
        public ?int $maxPurchase,
        public ?int $purchaseSteps,
    ) {
    }
}
