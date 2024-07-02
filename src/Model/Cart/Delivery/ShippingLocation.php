<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart\Delivery;

use ITB\ShopwareStoreApiClient\Model\Address\Country;
use ITB\ShopwareStoreApiClient\Model\Address\CountryState;
use ITB\ShopwareStoreApiClient\Model\Cart\CustomerAddress;

final readonly class ShippingLocation
{
    public function __construct(
        public ?CustomerAddress $address,
        public Country $country,
        public ?CountryState $state,
    ) {
    }
}
