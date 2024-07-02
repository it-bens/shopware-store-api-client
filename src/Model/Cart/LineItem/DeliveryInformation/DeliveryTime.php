<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart\LineItem\DeliveryInformation;

final readonly class DeliveryTime
{
    public function __construct(
        public string $name,
        public int $min,
        public int $max,
        public string $unit
    ) {
    }
}
