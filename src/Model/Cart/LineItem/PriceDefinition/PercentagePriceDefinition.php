<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart\LineItem\PriceDefinition;

use ITB\ShopwareStoreApiClient\Model\Cart\LineItem\PriceDefinition;
use ITB\ShopwareStoreApiClient\Model\Cart\LineItem\PriceDefinition\PercentagePriceDefinition\Rule;

final readonly class PercentagePriceDefinition implements PriceDefinition
{
    public function __construct(
        public float $percentage,
        public ?Rule $filter,
    ) {
    }

    public function getType(): string
    {
        return 'percentage';
    }
}
