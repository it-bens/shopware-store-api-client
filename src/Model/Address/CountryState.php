<?php

namespace ITB\ShopwareStoreApiClient\Model\Address;

final readonly class CountryState
{
    public function __construct(
        public string $id,
        public ?string $name,
        public string $shortCode,
        public Country $country
    ) {
    }
}
