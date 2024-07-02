<?php

namespace ITB\ShopwareStoreApiClient\Model\Common\CalculatedPrice;

final readonly class ReferencePrice
{
    public function __construct(
        public float $price,
        public float $purchaseUnit,
        public float $referenceUnit,
        public string $unitName,
    ) {
    }
}
