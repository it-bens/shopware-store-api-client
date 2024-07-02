<?php

namespace ITB\ShopwareStoreApiClient\Tests\E2E\Helper;

final readonly class CreateEmptyCartDataHelper
{
    /**
     * @return array{
     *     price: array{
     *         netPrice: float,
     *         totalPrice: float,
     *         calculatedTaxes: mixed[],
     *         taxRules: mixed[],
     *         positionPrice: float,
     *         taxStatus: string,
     *         rawTotal: float
     *     },
     *     lineItems: mixed[],
     *     deliveries: mixed[],
     *     transactions: mixed[],
     *     customerComment: string|null,
     *     affiliateCode: string|null,
     *     campaignCode: string|null,
     *     modified: string|null
     * }
     */
    public static function createEmptyCartData(): array
    {
        return [
            'price' => [
                'netPrice' => 0,
                'totalPrice' => 0,
                'calculatedTaxes' => [],
                'taxRules' => [],
                'positionPrice' => 0,
                'taxStatus' => 'gross',
                'rawTotal' => 0,
            ],
            'lineItems' => [],
            'deliveries' => [],
            'transactions' => [],
            'customerComment' => null,
            'affiliateCode' => null,
            'campaignCode' => null,
            'modified' => null,
        ];
    }
}
