<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart\Delivery;

use ITB\ShopwareStoreApiClient\Model\Cart\LineItem;
use ITB\ShopwareStoreApiClient\Model\Common\CalculatedPrice;

final readonly class DeliveryPosition
{
    public function __construct(
        public string $identifier,
        public LineItem $lineItem,
        public float $quantity,
        public CalculatedPrice $price,
        public DeliveryDate $deliveryDate,
    ) {
    }
}
