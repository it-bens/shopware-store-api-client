<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart;

use ITB\ShopwareStoreApiClient\Model\Cart\LineItem\DeliveryInformation;
use ITB\ShopwareStoreApiClient\Model\Cart\LineItem\PriceDefinition;
use ITB\ShopwareStoreApiClient\Model\Cart\LineItem\QuantityInformation;
use ITB\ShopwareStoreApiClient\Model\Cart\LineItem\State;
use ITB\ShopwareStoreApiClient\Model\Cart\LineItem\Type;
use ITB\ShopwareStoreApiClient\Model\Common\CalculatedPrice;

final readonly class LineItem
{
    public bool $isGood;

    /**
     * @param State[] $states
     * @param array<string, mixed> $payload
     * @param LineItem[] $children
     */
    public function __construct(
        public string $id,
        public string $uniqueIdentifier,
        public Type $type,
        public ?string $referencedId,
        public ?string $label,
        public ?string $description,
        public int $quantity,
        public ?PriceDefinition $priceDefinition,
        public ?CalculatedPrice $price,
        ?bool $isGood,
        // public ?MediaEntity $cover,
        public ?DeliveryInformation $deliveryInformation,
        public bool $removable,
        public bool $stackable,
        public ?QuantityInformation $quantityInformation,
        public bool $modified,
        public ?\DateTimeImmutable $dataTimestamp,
        public ?string $dataContextHash,
        public array $states,
        public array $payload,
        public array $children,
    ) {
        $this->isGood = $isGood ?? true;
    }
}
