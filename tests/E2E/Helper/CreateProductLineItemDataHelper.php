<?php

namespace ITB\ShopwareStoreApiClient\Tests\E2E\Helper;

final readonly class CreateProductLineItemDataHelper
{
    /**
     * @return array{type: string, referencedId: string, quantity: int}
     */
    public static function createProductLineItemData(string $productId, int $quantity): array
    {
        return [
            'type' => 'product',
            'referencedId' => $productId,
            'quantity' => $quantity,
        ];
    }
}
