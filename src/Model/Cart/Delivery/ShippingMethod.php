<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart\Delivery;

final readonly class ShippingMethod
{
    public function __construct(
        public string $id,
        public ?string $name,
        public ?string $description,
        public ?string $trackingUrl,
    ) {
    }
}
