<?php

namespace ITB\ShopwareStoreApiClient\Model\Address;

final readonly class Country
{
    /**
     * @param CountryState[] $states
     */
    public function __construct(
        public string $id,
        public ?string $name,
        public ?string $iso,
        public ?string $iso3,
        public ?array $states,
    ) {
    }
}
