<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart;

use ITB\ShopwareStoreApiClient\Model\Cart\Extension\CartPromotionsExtension;
use Symfony\Component\Serializer\Attribute\DiscriminatorMap;

#[DiscriminatorMap(typeProperty: 'apiAlias', mapping: [
    'shopware_core_checkout_promotion_cart_extension_cart_extension' => CartPromotionsExtension::class,
])]
interface Extension
{
}
