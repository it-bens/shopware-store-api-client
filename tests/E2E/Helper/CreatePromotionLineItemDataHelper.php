<?php

namespace ITB\ShopwareStoreApiClient\Tests\E2E\Helper;

final readonly class CreatePromotionLineItemDataHelper
{
    /**
     * @return array{type: string, referencedId: string}
     */
    public static function createPromotionLineItemData(string $code): array
    {
        return [
            'type' => 'promotion',
            'referencedId' => $code,
        ];
    }
}
