<?php

namespace ITB\ShopwareStoreApiClient\Model\Order;

use ITB\ShopwareStoreApiClient\Model\Address;
use ITB\ShopwareStoreApiClient\Model\Common\CalculatedPrice;
use ITB\ShopwareStoreApiClient\Model\Order\Delivery\DeliveryState;
use ITB\ShopwareStoreApiClient\Model\Order\Delivery\ShippingMethod;

final readonly class Delivery
{
    /**
     * @param string[] $trackingCodes
     */
    public function __construct(
        public string $id,
        public Address $shippingOrderAddress,
        public ShippingMethod $shippingMethod,
        public DeliveryState $stateMachineState,
        public array $trackingCodes,
        public \DateTimeImmutable $shippingDateEarliest,
        public \DateTimeImmutable $shippingDateLatest,
        public CalculatedPrice $shippingCosts,
        // public array $positions,
    ) {
    }
}
