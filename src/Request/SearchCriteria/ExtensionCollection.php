<?php

namespace ITB\ShopwareStoreApiClient\Request\SearchCriteria;

final class ExtensionCollection implements Extension
{
    /**
     * @var Extension[]
     */
    private array $extensions;

    public function __construct(Extension ...$extensions)
    {
        $this->extensions = $extensions;
    }

    public function addExtension(Extension $extension): void
    {
        $this->extensions[] = $extension;
    }

    public function getAggregations(?array $aggregations): ?array
    {
        foreach ($this->extensions as $extension) {
            $aggregations = $extension->getAggregations($aggregations);
        }

        return $aggregations;
    }

    public function getAssociations(?array $associations): ?array
    {
        foreach ($this->extensions as $extension) {
            $associations = $extension->getAssociations($associations);
        }

        return $associations;
    }

    public function getFields(?array $fields): ?array
    {
        foreach ($this->extensions as $extension) {
            $fields = $extension->getFields($fields);
        }

        return $fields;
    }

    public function getFilters(?array $filters): ?array
    {
        foreach ($this->extensions as $extension) {
            $filters = $extension->getFilters($filters);
        }

        return $filters;
    }

    public function getGrouping(?array $grouping): ?array
    {
        foreach ($this->extensions as $extension) {
            $grouping = $extension->getGrouping($grouping);
        }

        return $grouping;
    }

    public function getIds(?array $ids): ?array
    {
        foreach ($this->extensions as $extension) {
            $ids = $extension->getIds($ids);
        }

        return $ids;
    }

    public function getIncludes(?array $includes): ?array
    {
        foreach ($this->extensions as $extension) {
            $includes = $extension->getIncludes($includes);
        }

        return $includes;
    }

    public function getPostFilter(?array $postFilter): ?array
    {
        foreach ($this->extensions as $extension) {
            $postFilter = $extension->getPostFilter($postFilter);
        }

        return $postFilter;
    }

    public function getSorts(?array $sorts): ?array
    {
        foreach ($this->extensions as $extension) {
            $sorts = $extension->getSorts($sorts);
        }

        return $sorts;
    }
}
