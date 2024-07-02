<?php

namespace ITB\ShopwareStoreApiClient\Model\Address;

final readonly class Salutation
{
    public function __construct(
        public string $id,
        public string $salutationKey,
        public string $displayName,
        public string $letterName,
    ) {
    }
}
