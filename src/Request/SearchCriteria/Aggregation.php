<?php

namespace ITB\ShopwareStoreApiClient\Request\SearchCriteria;

use ITB\ShopwareStoreApiClient\Request\SearchCriteria\Aggregation\AggregationType;

/**
 * @phpstan-type AggregationPayload array{name: string, type: string, field: string}
 */
final readonly class Aggregation
{
    public function __construct(
        private string $name,
        private AggregationType $type,
        private string $field,
    ) {
    }

    /**
     * @return AggregationPayload
     */
    public function toPayload(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type->value,
            'field' => $this->field,
        ];
    }
}
