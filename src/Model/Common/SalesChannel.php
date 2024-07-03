<?php

namespace ITB\ShopwareStoreApiClient\Model\Common;

use ITB\ShopwareStoreApiClient\Model\Address\Country;
use ITB\ShopwareStoreApiClient\Model\Cart\Delivery\ShippingMethod;
use ITB\ShopwareStoreApiClient\Model\Common\SalesChannel\Domain;
use ITB\ShopwareStoreApiClient\Model\Common\SalesChannel\TaxCalculationType;
use ITB\ShopwareStoreApiClient\Model\Currency;
use ITB\ShopwareStoreApiClient\Model\Language;
use ITB\ShopwareStoreApiClient\Model\Order\Transaction\PaymentMethod;

final readonly class SalesChannel
{
    /**
     * @param Domain[] $domains
     */
    public function __construct(
        public string $id,
        public string $name,
        public ?string $shortName,
        public string $languageId,
        public ?Language $language,
        public string $currencyId,
        public ?Currency $currency,
        public string $paymentMethodId,
        public ?PaymentMethod $paymentMethod,
        public string $shippingMethodId,
        public ?ShippingMethod $shippingMethod,
        public string $countryId,
        public ?Country $country,
        public array $domains,
        public string $navigationCategoryId,
        public int $navigationCategoryDepth,
        public ?string $footerCategoryId,
        public ?string $serviceCategoryId,
        public bool $active,
        public bool $maintenance,
        public ?string $mailHeaderFooterId,
        public string $customerGroupId,
        public bool $hreflangActive,
        public ?string $hreflangDefaultDomainId,
        public ?Domain $hreflangDefaultDomain,
        public TaxCalculationType $taxCalculationType
    ) {
    }
}
