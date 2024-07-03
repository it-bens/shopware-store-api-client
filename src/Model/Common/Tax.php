<?php

namespace ITB\ShopwareStoreApiClient\Model\Common;

final readonly class Tax
{
    public function __construct(
        public string $id,
        public string $name,
        public float $taxRate,
        public int $position,
    ) {
    }
}
