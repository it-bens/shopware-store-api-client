<?php

namespace ITB\ShopwareStoreApiClient\Request\Order;

use ITB\ShopwareStoreApiClient\Request\SearchCriteria;
use ITB\ShopwareStoreApiClient\Request\SearchCriteria\Extension;

final readonly class DefaultOrderAssociationsExtension implements Extension
{
    public function getAggregations(?array $aggregations): ?array
    {
        return $aggregations;
    }

    public function getAssociations(?array $associations): ?array
    {
        $associations ??= [];

        $associations['orderCustomer'] = new SearchCriteria(
            associations: [
                'salutation' => new SearchCriteria(),
            ]
        );
        $associations['currency'] = new SearchCriteria();
        $associations['addresses'] = new SearchCriteria(
            associations: [
                'country' => new SearchCriteria(),
            ]
        );
        $associations['lineItems'] = new SearchCriteria();
        $associations['deliveries'] = new SearchCriteria(
            associations: [
                'shippingMethod' => new SearchCriteria(),
                'shippingOrderAddress' => new SearchCriteria(
                    associations: [
                        'country' => new SearchCriteria(),
                    ]
                ),
            ],
        );
        $associations['transactions'] = new SearchCriteria(
            associations: [
                'paymentMethod' => new SearchCriteria(),
            ]
        );

        return $associations;
    }

    public function getFields(?array $fields): ?array
    {
        return $fields;
    }

    public function getFilters(?array $filters): ?array
    {
        return $filters;
    }

    public function getGrouping(?array $grouping): ?array
    {
        return $grouping;
    }

    public function getIds(?array $ids): ?array
    {
        return $ids;
    }

    public function getIncludes(?array $includes): ?array
    {
        return $includes;
    }

    public function getPostFilter(?array $postFilter): ?array
    {
        return $postFilter;
    }

    public function getSorts(?array $sorts): ?array
    {
        return $sorts;
    }
}
