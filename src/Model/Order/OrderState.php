<?php

namespace ITB\ShopwareStoreApiClient\Model\Order;

enum OrderState: string
{
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';
    case IN_PROGRESS = 'in_progress';
    case OPEN = 'open';
}
