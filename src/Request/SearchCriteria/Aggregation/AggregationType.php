<?php

namespace ITB\ShopwareStoreApiClient\Request\SearchCriteria\Aggregation;

enum AggregationType: string
{
    case AVG = 'avg';
    case COUNT = 'count';
    case ENTITY = 'entity';
    case FILTER = 'filter';
    case HISTOGRAM = 'histogram';
    case MAX = 'max';
    case MIN = 'min';
    case RANGE = 'range';
    case STATS = 'stats';
    case SUM = 'sum';
    case TERMS = 'terms';
}
