<?php

namespace ITB\ShopwareStoreApiClient\Request\SearchCriteria;

enum TotalCountMode: string
{
    case EXACT = 'exact';
    case NEXT_PAGES = 'next-pages';
    case NONE = 'none';
}
