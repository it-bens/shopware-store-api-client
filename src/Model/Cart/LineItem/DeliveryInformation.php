<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart\LineItem;

use ITB\ShopwareStoreApiClient\Model\Cart\LineItem\DeliveryInformation\DeliveryTime;

final readonly class DeliveryInformation
{
    public function __construct(
        public int $stock,
        public ?float $weight,
        public bool $freeDelivery,
        public ?int $restockTime,
        public ?DeliveryTime $deliveryTime,
        public ?float $height,
        public ?float $width,
        public ?float $length,
    ) {
    }
}
