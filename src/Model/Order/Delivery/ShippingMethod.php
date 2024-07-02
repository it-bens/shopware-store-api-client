<?php

namespace ITB\ShopwareStoreApiClient\Model\Order\Delivery;

use ITB\ShopwareStoreApiClient\Model\Order\Delivery\ShippingMethod\TaxType;

final readonly class ShippingMethod
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $description,
        public ?string $trackingUrl,
        public string $technicalName,
        public TaxType $taxType,
    ) {
    }
}
