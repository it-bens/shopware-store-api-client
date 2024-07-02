<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart\LineItem\PriceDefinition\PercentagePriceDefinition;

final readonly class Rule
{
    /**
     * @param string[] $productIds
     */
    public function __construct(
        public array $productIds,
    ) {
    }
}
