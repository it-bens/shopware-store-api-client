<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart\Delivery;

final readonly class DeliveryDate
{
    public function __construct(
        public \DateTimeImmutable $earliest,
        public \DateTimeImmutable $latest
    ) {
    }
}
