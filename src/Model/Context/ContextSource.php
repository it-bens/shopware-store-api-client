<?php

namespace ITB\ShopwareStoreApiClient\Model\Context;

enum ContextSource: string
{
    case ADMIN_API = 'admin-api';
    case SALES_CHANNEL = 'sales-channel';
    case SYSTEM = 'system';
}
