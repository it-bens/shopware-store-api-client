<?php

namespace ITB\ShopwareStoreApiClient\Model\Common;

final readonly class CashRoundingConfig
{
    public function __construct(
        public int $decimals,
        public float $interval,
        public bool $roundForNet,
    ) {
    }
}
