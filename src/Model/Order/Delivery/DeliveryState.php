<?php

namespace ITB\ShopwareStoreApiClient\Model\Order\Delivery;

enum DeliveryState: string
{
    case CANCELLED = 'cancelled';
    case OPEN = 'open';
    case RETURNED = 'returned';
    case RETURNED_PARTIALLY = 'returned_partially';
    case SHIPPED = 'shipped';
    case SHIPPED_PARTIALLY = 'shipped_partially';
}
