<?php

namespace ITB\ShopwareStoreApiClient\Request\Cart\LineItem;

/**
 * @phpstan-type LineItemReferencePayload array{id: string}
 */
final readonly class LineItemReference implements LineItem
{
    public function __construct(
        private string $lineItemId
    ) {
    }

    public function hasId(): bool
    {
        return true;
    }

    public function toPayload(): array
    {
        return [
            'id' => $this->lineItemId,
        ];
    }
}
