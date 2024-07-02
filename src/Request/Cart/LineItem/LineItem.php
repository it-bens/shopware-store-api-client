<?php

namespace ITB\ShopwareStoreApiClient\Request\Cart\LineItem;

/**
 * @phpstan-import-type LineItemReferencePayload from LineItemReference
 * @phpstan-import-type ProductLineItemPayload from ProductLineItem
 * @phpstan-import-type PromotionLineItemPayload from PromotionLineItem
 * @phpstan-type LineItemPayload LineItemReferencePayload|ProductLineItemPayload|PromotionLineItemPayload
 */
interface LineItem
{
    public function hasId(): bool;

    /**
     * @return LineItemPayload
     */
    public function toPayload(): array;
}
