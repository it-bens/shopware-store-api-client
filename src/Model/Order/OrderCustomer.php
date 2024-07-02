<?php

namespace ITB\ShopwareStoreApiClient\Model\Order;

use ITB\ShopwareStoreApiClient\Model\Address\Salutation;

final readonly class OrderCustomer
{
    /**
     * @param string[]|null $vatIds
     */
    public function __construct(
        public string $id,
        public string $email,
        public Salutation $salutation,
        public ?string $title,
        public string $firstName,
        public string $lastName,
        public ?string $company,
        public ?array $vatIds,
        public ?string $customerNumber,
    ) {
    }
}
