<?php

namespace ITB\ShopwareStoreApiClient\Request\SearchCriteria;

use ITB\ShopwareStoreApiClient\Request\SearchCriteria\Filter\FilterType;
use phpDocumentor\Reflection\Type;

/**
 * @phpstan-type FilterPayload array{type: string, field: string, value: string}
 */
final readonly class Filter
{
    public function __construct(
        private FilterType $type,
        private string $field,
        private string $value
    ) {
    }

    /**
     * @return FilterPayload
     */
    public function toPayload(): array
    {
        return [
            'type' => $this->type->value,
            'field' => $this->field,
            'value' => $this->value,
        ];
    }
}
