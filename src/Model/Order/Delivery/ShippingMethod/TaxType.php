<?php

namespace ITB\ShopwareStoreApiClient\Model\Order\Delivery\ShippingMethod;

enum TaxType: string
{
    case AUTO = 'auto';
    case FIXED = 'fixed';
    case HIGHEST = 'highest';
}
