<?php

namespace ITB\ShopwareStoreApiClient\Model\Order\Transaction;

final readonly class PaymentMethod
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $distinguishableName,
        public ?string $description,
        public bool $synchronous,
        public bool $asynchronous,
        public bool $prepared,
        public bool $refundable,
        public bool $recurring,
        public ?string $shortName,
        public string $technicalName
    ) {
    }
}
