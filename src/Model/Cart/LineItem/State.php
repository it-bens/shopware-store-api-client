<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart\LineItem;

enum State: string
{
    case IS_DOWNLOAD = 'is-download';
    case IS_PHYSICAL = 'is-physical';
}
