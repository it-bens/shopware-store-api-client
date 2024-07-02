<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart;

use ITB\ShopwareStoreApiClient\Model\Cart\Error\ProductNotFoundError;
use ITB\ShopwareStoreApiClient\Model\Cart\Error\PromotionDiscountAddedMessage;
use ITB\ShopwareStoreApiClient\Model\Cart\Error\PromotionNotFoundError;
use ITB\ShopwareStoreApiClient\Model\Cart\Error\SalutationMissingInBillingAddressError;
use Symfony\Component\Serializer\Attribute\DiscriminatorMap;

#[DiscriminatorMap(typeProperty: 'messageKey', mapping: [
    'product-not-found' => ProductNotFoundError::class,
    'promotion-not-found' => PromotionNotFoundError::class,
    'promotion-discount-added' => PromotionDiscountAddedMessage::class,
    'salutation-missing-billing-address' => SalutationMissingInBillingAddressError::class,
])]
interface Error
{
    public const LEVEL_ERROR = 20;

    public const LEVEL_NOTICE = 0;

    public const LEVEL_WARNING = 10;

    public function getMessageKey(): string;

    public function isError(): bool;

    public function isNotice(): bool;

    public function isWarning(): bool;
}
