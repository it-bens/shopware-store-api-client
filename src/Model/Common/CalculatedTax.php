<?php

namespace ITB\ShopwareStoreApiClient\Model\Common;

final readonly class CalculatedTax
{
    public function __construct(
        public float $tax,
        public float $taxRate,
        public float $price,
    ) {
    }
}
