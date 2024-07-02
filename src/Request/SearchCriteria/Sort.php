<?php

namespace ITB\ShopwareStoreApiClient\Request\SearchCriteria;

/**
 * @phpstan-type SortPayload array{field: string, order: string|null, naturalSorting: bool|null}
 */
final readonly class Sort
{
    public function __construct(
        private string $field,
        private ?string $order,
        private ?bool $naturalSorting
    ) {
    }

    /**
     * @return SortPayload
     */
    public function toPayload(): array
    {
        return [
            'field' => $this->field,
            'order' => $this->order,
            'naturalSorting' => $this->naturalSorting,
        ];
    }
}
