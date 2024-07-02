<?php

namespace ITB\ShopwareStoreApiClient\Request\Cart\LineItem;

/**
 * @phpstan-import-type LineItemPayload from LineItem
 */
final class LineItemCollection
{
    /**
     * @var LineItem[]
     */
    private array $lineItems;

    public function __construct(LineItem ...$lineItems)
    {
        $this->lineItems = $lineItems;
    }

    public function add(LineItem $lineItem): void
    {
        $this->lineItems[] = $lineItem;
    }

    public function allLineItemsHaveIds(): bool
    {
        $allLineItemsHaveIds = true;
        foreach ($this->lineItems as $lineItem) {
            if ($lineItem->hasId() === false) {
                $allLineItemsHaveIds = false;
                break;
            }
        }

        return $allLineItemsHaveIds;
    }

    public function isEmpty(): bool
    {
        return $this->lineItems === [];
    }

    /**
     * @return array{ids: string[]}
     */
    public function toIdsPayload(): array
    {
        $ids = [];
        foreach ($this->lineItems as $lineItem) {
            $lineItemPayload = $lineItem->toPayload();
            $ids[] = $lineItemPayload['id'] ?? null;
        }

        return [
            'ids' => array_filter($ids),
        ];
    }

    /**
     * @return array{items: LineItemPayload[]}
     */
    public function toPayload(): array
    {
        return [
            'items' => array_map(fn (LineItem $lineItem): array => $lineItem->toPayload(), $this->lineItems),
        ];
    }
}
