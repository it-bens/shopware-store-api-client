<?php

namespace ITB\ShopwareStoreApiClient\Model\Context;

enum ContextScope: string
{
    case CRUD_API = 'crud';
    case SYSTEM = 'system';
    case USER = 'user';
}
