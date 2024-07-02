<?php

namespace ITB\ShopwareStoreApiClient\Model\Common\CalculatedPrice;

final readonly class ListPrice
{
    public function __construct(
        public float $price,
        public float $discount,
        public float $percentage
    ) {
    }
}
