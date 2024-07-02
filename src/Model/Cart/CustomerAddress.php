<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart;

use ITB\ShopwareStoreApiClient\Model\Address;

final readonly class CustomerAddress
{
    public function __construct(
        public string $customerId,
        public Address $address
    ) {
    }
}
