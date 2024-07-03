<?php

namespace ITB\ShopwareStoreApiClient\Model\Common;

use ITB\ShopwareStoreApiClient\Model\Address\Salutation;
use ITB\ShopwareStoreApiClient\Model\Cart\CustomerAddress;
use ITB\ShopwareStoreApiClient\Model\Common\Customer\AccountType;
use ITB\ShopwareStoreApiClient\Model\Language;

final readonly class Customer
{
    /**
     * @param string[]|null $vatIds
     */
    public function __construct(
        public string $id,
        public string $customerNumber,
        public bool $guest,
        public ?AccountType $accountType,
        public ?string $email,
        public ?string $salutationId,
        public ?Salutation $salutation,
        public ?string $title,
        public string $firstName,
        public string $lastName,
        public ?string $company,
        public ?array $vatIds,
        public ?\DateTimeImmutable $birthday,
        public string $languageId,
        public ?Language $language,
        public string $defaultBillingAddressId,
        public ?CustomerAddress $defaultBillingAddress,
        public ?CustomerAddress $activeBillingAddress,
        public string $defaultShippingAddressId,
        public ?CustomerAddress $defaultShippingAddress,
        public ?CustomerAddress $activeShippingAddress,
        public string $groupId,
        public string $salesChannelId,
        public string $defaultPaymentMethodId,
        public ?string $lastPaymentMethodId,
        public bool $active,
        public ?\DateTimeImmutable $firstLogin,
        public ?\DateTimeImmutable $lastLogin,
        public ?bool $doubleOptInRegistration,
        public ?\DateTimeImmutable $doubleOptInEmailSentDate,
        public ?\DateTimeImmutable $doubleOptInConfirmDate,
        public ?string $affiliateCode,
        public ?string $campaignCode,
        public ?\DateTimeImmutable $lastOrderDate,
        public int $orderCount,
        public float $orderTotalAmount,
        public int $reviewCount,
    ) {
    }
}
