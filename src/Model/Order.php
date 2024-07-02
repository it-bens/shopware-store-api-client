<?php

namespace ITB\ShopwareStoreApiClient\Model;

use ITB\ShopwareStoreApiClient\Model\Common\CalculatedPrice;
use ITB\ShopwareStoreApiClient\Model\Common\CartPrice;
use ITB\ShopwareStoreApiClient\Model\Common\TaxStatus;
use ITB\ShopwareStoreApiClient\Model\Order\Delivery;
use ITB\ShopwareStoreApiClient\Model\Order\LineItem;
use ITB\ShopwareStoreApiClient\Model\Order\OrderCustomer;
use ITB\ShopwareStoreApiClient\Model\Order\OrderState;
use ITB\ShopwareStoreApiClient\Model\Order\Transaction;

final readonly class Order
{
    /**
     * @param Address[] $addresses
     * @param LineItem[] $lineItems
     * @param Delivery[] $deliveries
     * @param Transaction[] $transactions
     */
    public function __construct(
        public string $id,
        public string $orderNumber,
        public string $salesChannelId,
        public \DateTimeImmutable $orderDateTime,
        public \DateTimeImmutable $orderDate,
        public CartPrice $price,
        public float $amountTotal,
        public float $amountNet,
        public float $positionPrice,
        public TaxStatus $taxStatus,
        public CalculatedPrice $shippingCosts,
        public float $shippingTotal,
        public float $currencyFactor,
        public ?string $deepLinkCode,
        public ?string $affiliateCode,
        public ?string $campaignCode,
        public ?string $customerComment,
        public OrderState $stateMachineState,
        public OrderCustomer $orderCustomer,
        public string $currencyId,
        public ?Currency $currency,
        public string $languageId,
        public ?Language $language,
        public array $addresses,
        public string $billingAddressId,
        public ?Address $billingAddress,
        public array $lineItems,
        public array $deliveries,
        public array $transactions,
    ) {
    }
}
