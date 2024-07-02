<?php

namespace ITB\ShopwareStoreApiClient\Model\Common;

final readonly class CartPrice
{
    /**
     * @param CalculatedTax[] $calculatedTaxes
     * @param TaxRule[] $taxRules
     */
    public function __construct(
        public float $netPrice,
        public float $totalPrice,
        public array $calculatedTaxes,
        public array $taxRules,
        public float $positionPrice,
        public float $rawTotal,
        public TaxStatus $taxStatus,
    ) {
    }
}
