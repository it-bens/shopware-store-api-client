<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart;

use ITB\ShopwareStoreApiClient\Model\Cart\Delivery\DeliveryDate;
use ITB\ShopwareStoreApiClient\Model\Cart\Delivery\DeliveryPosition;
use ITB\ShopwareStoreApiClient\Model\Cart\Delivery\ShippingLocation;
use ITB\ShopwareStoreApiClient\Model\Cart\Delivery\ShippingMethod;
use ITB\ShopwareStoreApiClient\Model\Common\CalculatedPrice;

final readonly class Delivery
{
    /**
     * @param DeliveryPosition[] $positions
     */
    public function __construct(
        public array $positions,
        public DeliveryDate $deliveryDate,
        public ShippingMethod $shippingMethod,
        public ShippingLocation $location,
        public CalculatedPrice $shippingCosts
    ) {
    }
}
