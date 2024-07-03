<?php

namespace ITB\ShopwareStoreApiClient\Request\Context;

final readonly class ContextData
{
    public function __construct(
        private ?string $currencyId = null,
        private ?string $languageId = null,
        private ?string $billingAddressId = null,
        private ?string $shippingAddressId = null,
        private ?string $paymentMethodId = null,
        private ?string $shippingMethodId = null,
        private ?string $countryId = null,
        private ?string $countryStateId = null,
    ) {
    }

    /**
     * @return array{
     *     currencyId: string|null,
     *     languageId: string|null,
     *     billingAddressId: string|null,
     *     shippingAddressId: string|null,
     *     paymentMethodId: string|null,
     *     shippingMethodId: string|null,
     *     countryId: string|null,
     *     countryStateId: string|null,
     * }
     */
    public function toPayload(): array
    {
        return [
            'currencyId' => $this->currencyId,
            'languageId' => $this->languageId,
            'billingAddressId' => $this->billingAddressId,
            'shippingAddressId' => $this->shippingAddressId,
            'paymentMethodId' => $this->paymentMethodId,
            'shippingMethodId' => $this->shippingMethodId,
            'countryId' => $this->countryId,
            'countryStateId' => $this->countryStateId,
        ];
    }
}
