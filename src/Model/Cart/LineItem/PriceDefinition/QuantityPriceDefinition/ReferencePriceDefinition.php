<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart\LineItem\PriceDefinition\QuantityPriceDefinition;

final readonly class ReferencePriceDefinition
{
    public function __construct(
        public float $purchaseUnit,
        public float $referenceUnit,
        public float $unitName,
    ) {
    }
}
