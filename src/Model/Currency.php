<?php

namespace ITB\ShopwareStoreApiClient\Model;

use ITB\ShopwareStoreApiClient\Model\Common\CashRoundingConfig;

final readonly class Currency
{
    public function __construct(
        public string $id,
        public float $factor,
        public string $symbol,
        public string $isoCode,
        public string $shortName,
        public string $name,
        public bool $isSystemDefault,
        public ?float $isTaxFreeFrom,
        public CashRoundingConfig $itemRounding,
        public CashRoundingConfig $totalRounding,
    ) {
    }
}
