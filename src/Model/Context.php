<?php

namespace ITB\ShopwareStoreApiClient\Model;

use ITB\ShopwareStoreApiClient\Model\Cart\Delivery\ShippingLocation;
use ITB\ShopwareStoreApiClient\Model\Cart\Delivery\ShippingMethod;
use ITB\ShopwareStoreApiClient\Model\Common\CashRoundingConfig;
use ITB\ShopwareStoreApiClient\Model\Common\Customer;
use ITB\ShopwareStoreApiClient\Model\Common\CustomerGroup;
use ITB\ShopwareStoreApiClient\Model\Common\SalesChannel;
use ITB\ShopwareStoreApiClient\Model\Common\Tax;
use ITB\ShopwareStoreApiClient\Model\Context\CoreContext;
use ITB\ShopwareStoreApiClient\Model\Order\Transaction\PaymentMethod;

final readonly class Context
{
    /**
     * @param Tax[] $taxRules
     */
    public function __construct(
        public string $token,
        public ?Customer $customer,
        public SalesChannel $salesChannel,
        public Currency $currency,
        public CustomerGroup $currentCustomerGroup,
        public ?CustomerGroup $fallbackCustomerGroup,
        public array $taxRules,
        public PaymentMethod $paymentMethod,
        public ShippingMethod $shippingMethod,
        public ShippingLocation $shippingLocation,
        public CoreContext $context,
        public CashRoundingConfig $itemRounding,
        public CashRoundingConfig $totalRounding
    ) {
    }
}
