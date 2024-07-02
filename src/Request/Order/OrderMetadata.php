<?php

namespace ITB\ShopwareStoreApiClient\Request\Order;

final readonly class OrderMetadata
{
    public function __construct(
        private ?string $customerComment,
        private ?string $affiliateCode,
        private ?string $campaignCode,
    ) {
    }

    /**
     * @return array{
     *     customerComment: string|null,
     *     affiliateCode: string|null,
     *     campaignCode: string|null,
     * }
     */
    public function toPayload(): array
    {
        return [
            'customerComment' => $this->customerComment,
            'affiliateCode' => $this->affiliateCode,
            'campaignCode' => $this->campaignCode,
        ];
    }
}
