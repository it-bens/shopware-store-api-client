<?php

namespace ITB\ShopwareStoreApiClient\Request\SearchCriteria;

use ITB\ShopwareStoreApiClient\Request\SearchCriteria;

interface Extension
{
    /**
     * @param Aggregation[]|null $aggregations
     * @return Aggregation[]|null
     */
    public function getAggregations(?array $aggregations): ?array;

    /**
     * @param SearchCriteria[]|null $associations
     * @return SearchCriteria[]|null
     */
    public function getAssociations(?array $associations): ?array;

    /**
     * @param string[]|null $fields
     * @return string[]|null
     */
    public function getFields(?array $fields): ?array;

    /**
     * @param Filter[]|null $filters
     * @return Filter[]|null
     */
    public function getFilters(?array $filters): ?array;

    /**
     * @param string[]|null $grouping
     * @return string[]|null
     */
    public function getGrouping(?array $grouping): ?array;

    /**
     * @param string[]|null $ids
     * @return string[]|null
     */
    public function getIds(?array $ids): ?array;

    /**
     * @param AliasInclude[]|null $includes
     * @return AliasInclude[]|null
     */
    public function getIncludes(?array $includes): ?array;

    /**
     * @param Filter[]|null $postFilter
     * @return Filter[]|null
     */
    public function getPostFilter(?array $postFilter): ?array;

    /**
     * @param Sort[]|null $sorts
     * @return Sort[]|null
     */
    public function getSorts(?array $sorts): ?array;
}
