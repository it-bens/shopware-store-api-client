<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart\LineItem;

enum Type: string
{
    case CONTAINER = 'container';
    case CREDIT = 'credit';
    case CUSTOM = 'custom';
    case DISCOUNT = 'discount';
    case PRODUCT = 'product';
    case PROMOTION = 'promotion';
    case QUANTITY = 'quantity';
}
