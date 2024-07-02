<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart\Extension;

final readonly class CartPromotionsExtension
{
    /**
     * @param string[] $addedCodes
     * @param string[] $blockedPromotionIds
     */
    public function __construct(
        public array $addedCodes,
        public array $blockedPromotionIds,
    ) {
    }
}
