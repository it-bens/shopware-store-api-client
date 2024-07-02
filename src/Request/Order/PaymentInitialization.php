<?php

namespace ITB\ShopwareStoreApiClient\Request\Order;

final readonly class PaymentInitialization
{
    /**
     * @param array<string, mixed> $paymentDetails
     */
    public function __construct(
        private string $orderId,
        private string $finishUrl,
        private string $errorUrl,
        private array $paymentDetails
    ) {
    }

    /**
     * @return array{
     *     orderId: string,
     *     finishUrl: string,
     *     errorUrl: string,
     *     paymentDetails: array<string, mixed>
     * }
     */
    public function toPayload(): array
    {
        return [
            'orderId' => $this->orderId,
            'finishUrl' => $this->finishUrl,
            'errorUrl' => $this->errorUrl,
            'paymentDetails' => $this->paymentDetails,
        ];
    }
}
