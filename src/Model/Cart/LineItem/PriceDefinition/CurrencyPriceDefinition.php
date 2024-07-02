<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart\LineItem\PriceDefinition;

use ITB\ShopwareStoreApiClient\Model\Cart\LineItem\PriceDefinition;
use ITB\ShopwareStoreApiClient\Model\Common\CalculatedPrice;

final readonly class CurrencyPriceDefinition implements PriceDefinition
{
    /**
     * @param CalculatedPrice[] $price
     */
    public function __construct(
        public array $price
    ) {
    }

    public function getType(): string
    {
        return 'currency-price';
    }
}
