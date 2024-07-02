<?php

namespace ITB\ShopwareStoreApiClient\Request\SearchCriteria\Filter;

enum FilterType: string
{
    case CONTAINS = 'contains';
    case EQUALS_ANY = 'equalsAny';
    case PREFIX = 'prefix';
    case SUFFIX = 'suffix';
}
