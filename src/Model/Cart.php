<?php

namespace ITB\ShopwareStoreApiClient\Model;

use ITB\ShopwareStoreApiClient\Model\Cart\Delivery;
use ITB\ShopwareStoreApiClient\Model\Cart\Error;
use ITB\ShopwareStoreApiClient\Model\Cart\Extension;
use ITB\ShopwareStoreApiClient\Model\Cart\LineItem;
use ITB\ShopwareStoreApiClient\Model\Cart\Transaction;
use ITB\ShopwareStoreApiClient\Model\Common\CartPrice;

final readonly class Cart
{
    /**
     * @param LineItem[] $lineItems
     * @param Delivery[] $deliveries
     * @param Transaction[] $transactions
     * @param array<string, Extension>|null $extensions
     * @param array<string, Error> $errors
     */
    public function __construct(
        public string $token,
        public CartPrice $price,
        public array $lineItems,
        public array $deliveries,
        public array $transactions,
        public ?string $customerComment,
        public ?string $affiliateCode,
        public ?string $campaignCode,
        public bool $modified,
        public ?array $extensions,
        public array $errors,
    ) {
    }
}
