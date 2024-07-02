<?php

namespace ITB\ShopwareStoreApiClient\Request\Cart\LineItem;

/**
 * @phpstan-type PromotionLineItemPayload array{id?: string, type: 'promotion', referencedId: string}
 */
final readonly class PromotionLineItem implements LineItem
{
    public function __construct(
        private ?string $lineItemId,
        private string $code
    ) {
    }

    public function hasId(): bool
    {
        return $this->lineItemId !== null;
    }

    public function toPayload(): array
    {
        $payload = [
            'type' => 'promotion',
            'referencedId' => $this->code,
        ];

        if ($this->lineItemId !== null) {
            $payload['id'] = $this->lineItemId;
        }

        return $payload;
    }
}
