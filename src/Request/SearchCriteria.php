<?php

namespace ITB\ShopwareStoreApiClient\Request;

use ITB\ShopwareStoreApiClient\Request\SearchCriteria\Aggregation;
use ITB\ShopwareStoreApiClient\Request\SearchCriteria\AliasInclude;
use ITB\ShopwareStoreApiClient\Request\SearchCriteria\Filter;
use ITB\ShopwareStoreApiClient\Request\SearchCriteria\Sort;
use ITB\ShopwareStoreApiClient\Request\SearchCriteria\TotalCountMode;

/**
 * @phpstan-import-type FilterPayload from Filter
 * @phpstan-import-type SortPayload from Sort
 * @phpstan-import-type AggregationPayload from Aggregation
 * @phpstan-import-type AliasIncludePayload from AliasInclude
 * @phpstan-type SearchCriteriaPayload = array{
 *     page?: int,
 *     limit?: int,
 *     totalCountMode?: string,
 *     filter?: FilterPayload[],
 *     ids?: string[],
 *     sort?: SortPayload[],
 *     postFilter?: FilterPayload[],
 *     associations?: array<string, mixed>,
 *     aggregations?: AggregationPayload[],
 *     grouping?: string[],
 *     fields?: string[],
 *     includes?: array<string, AliasIncludePayload>
 * }
 */
final readonly class SearchCriteria
{
    /**
     * @param Filter[]|null $filter
     * @param string[]|null $ids
     * @param Sort[]|null $sort
     * @param Filter[]|null $postFilter
     * @param array<string, SearchCriteria>|null $associations
     * @param Aggregation[]|null $aggregations
     * @param string[]|null $grouping
     * @param string[]|null $fields
     * @param array<string, AliasInclude>|null $includes
     */
    public function __construct(
        private ?int $page = null,
        private ?int $limit = null,
        private ?TotalCountMode $totalCountMode = null,
        private ?array $filter = null,
        private ?array $ids = null,
        private ?array $sort = null,
        private ?array $postFilter = null,
        private ?array $associations = null,
        private ?array $aggregations = null,
        private ?array $grouping = null,
        private ?array $fields = null,
        private ?array $includes = null,
    ) {
    }

    /**
     * @return SearchCriteriaPayload
     */
    public function toPayload(): array
    {
        $filter = null;
        if ($this->filter !== null) {
            $filter = array_map(fn (Filter $filter): array => $filter->toPayload(), $this->filter);
        }

        $sort = null;
        if ($this->sort !== null) {
            $sort = array_map(fn (Sort $sort): array => $sort->toPayload(), $this->sort);
        }

        $postFilter = null;
        if ($this->postFilter !== null) {
            $postFilter = array_map(fn (Filter $filter): array => $filter->toPayload(), $this->postFilter);
        }

        $associations = null;
        if ($this->associations !== null) {
            $associations = array_map(fn (SearchCriteria $criteria): array => $criteria->toPayload(), $this->associations);
        }

        $aggregations = null;
        if ($this->aggregations !== null) {
            $aggregations = array_map(fn (Aggregation $aggregation): array => $aggregation->toPayload(), $this->aggregations);
        }

        $includes = null;
        if ($this->includes !== null) {
            $includes = array_map(fn (AliasInclude $include): array => $include->toPayload(), $this->includes);
        }

        $payload = [
            'page' => $this->page,
            'limit' => $this->limit,
            'totalCountMode' => $this->totalCountMode?->value,
            'filter' => $filter,
            'ids' => $this->ids,
            'sort' => $sort,
            'postFilter' => $postFilter,
            'associations' => $associations,
            'aggregations' => $aggregations,
            'grouping' => $this->grouping,
            'fields' => $this->fields,
            'includes' => $includes,
        ];

        return array_filter($payload);
    }
}
