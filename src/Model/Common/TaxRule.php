<?php

namespace ITB\ShopwareStoreApiClient\Model\Common;

final readonly class TaxRule
{
    public function __construct(
        public float $taxRate,
        public float $percentage,
    ) {
    }
}
