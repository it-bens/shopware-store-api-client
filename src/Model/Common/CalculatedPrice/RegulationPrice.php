<?php

namespace ITB\ShopwareStoreApiClient\Model\Common\CalculatedPrice;

final readonly class RegulationPrice
{
    public function __construct(
        public float $price,
    ) {
    }
}
