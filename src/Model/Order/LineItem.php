<?php

namespace ITB\ShopwareStoreApiClient\Model\Order;

final readonly class LineItem
{
    /**
     * @param array<string, mixed>|null $payload
     * @param string[] $states
     */
    public function __construct(
        public string $id,
        public ?string $productId,
        public ?string $coverId,
        public string $identifier,
        public ?string $referencedId,
        public int $quantity,
        public string $label,
        public ?array $payload,
        public ?bool $good,
        public ?bool $removable,
        public ?bool $stackable,
        public int $position,
        public array $states,
        // public PriceDefinition $priceDefinition,
        public float $unitPrice,
        public float $totalPrice,
        public ?string $description,
        public string $type,
    ) {
    }
}
