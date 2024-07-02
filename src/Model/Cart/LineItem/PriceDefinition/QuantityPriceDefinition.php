<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart\LineItem\PriceDefinition;

use ITB\ShopwareStoreApiClient\Model\Cart\LineItem\PriceDefinition;
use ITB\ShopwareStoreApiClient\Model\Cart\LineItem\PriceDefinition\QuantityPriceDefinition\ReferencePriceDefinition;
use ITB\ShopwareStoreApiClient\Model\Common\TaxRule;

final readonly class QuantityPriceDefinition implements PriceDefinition
{
    /**
     * @param TaxRule[] $taxRules
     */
    public function __construct(
        public float $price,
        public array $taxRules,
        public int $quantity,
        public bool $isCalculated,
        public ?ReferencePriceDefinition $referencePriceDefinition,
        public ?float $listPrice,
        public ?float $regulationPrice,
    ) {
    }

    public function getType(): string
    {
        return 'quantity';
    }
}
