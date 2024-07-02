<?php

namespace ITB\ShopwareStoreApiClient\Request\Cart\LineItem;

/**
 * @phpstan-type ProductLineItemPayload array{id?: string, type: 'product', referencedId: string, quantity: int}
 */
final readonly class ProductLineItem implements LineItem
{
    public function __construct(
        private ?string $lineItemId,
        private string $productId,
        private int $quantity,
    ) {
    }

    public function hasId(): bool
    {
        return $this->lineItemId !== null;
    }

    public function toPayload(): array
    {
        $payload = [
            'type' => 'product',
            'referencedId' => $this->productId,
            'quantity' => $this->quantity,
        ];

        if ($this->lineItemId !== null) {
            $payload['id'] = $this->lineItemId;
        }

        return $payload;
    }
}
