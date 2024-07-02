<?php

namespace ITB\ShopwareStoreApiClient\Model\Order;

use ITB\ShopwareStoreApiClient\Model\Common\CalculatedPrice;
use ITB\ShopwareStoreApiClient\Model\Order\Transaction\PaymentMethod;
use ITB\ShopwareStoreApiClient\Model\Order\Transaction\TransactionState;

final readonly class Transaction
{
    public function __construct(
        public string $id,
        public PaymentMethod $paymentMethod,
        public CalculatedPrice $amount,
        public TransactionState $stateMachineState,
    ) {
    }
}
