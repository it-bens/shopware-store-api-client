<?php

namespace ITB\ShopwareStoreApiClient\Model\Common;

use ITB\ShopwareStoreApiClient\Model\Common\CalculatedPrice\ListPrice;
use ITB\ShopwareStoreApiClient\Model\Common\CalculatedPrice\ReferencePrice;
use ITB\ShopwareStoreApiClient\Model\Common\CalculatedPrice\RegulationPrice;

final readonly class CalculatedPrice
{
    /**
     * @param CalculatedTax[] $calculatedTaxes
     * @param TaxRule[] $taxRules
     */
    public function __construct(
        public float $unitPrice,
        public int $quantity,
        public float $totalPrice,
        public array $calculatedTaxes,
        public array $taxRules,
        public ?ReferencePrice $referencePrice,
        public ?ListPrice $listPrice,
        public ?RegulationPrice $regulationPrice
    ) {
    }
}
