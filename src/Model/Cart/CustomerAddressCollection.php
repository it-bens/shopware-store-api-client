<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart;

final readonly class CustomerAddressCollection
{
    /**
     * @param CustomerAddress[] $elements
     */
    public function __construct(
        public array $elements
    ) {
    }
}
