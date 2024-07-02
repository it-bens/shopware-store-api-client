<?php

namespace ITB\ShopwareStoreApiClient\Request\SearchCriteria;

/**
 * @phpstan-type AliasIncludePayload array{fields: string[]}
 */
final readonly class AliasInclude
{
    /**
     * @param string[] $fields
     */
    public function __construct(
        private array $fields
    ) {
    }

    /**
     * @return AliasIncludePayload
     */
    public function toPayload(): array
    {
        return [
            'fields' => $this->fields,
        ];
    }
}
