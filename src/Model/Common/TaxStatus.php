<?php

namespace ITB\ShopwareStoreApiClient\Model\Common;

enum TaxStatus: string
{
    case FREE = 'free';
    case GROSS = 'gross';
    case NET = 'net';
}
