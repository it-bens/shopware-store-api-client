<?php

namespace ITB\ShopwareStoreApiClient\Model\Order\Transaction;

enum TransactionState: string
{
    case AUTHORIZED = 'authorized';
    case CANCELLED = 'cancelled';
    case FAILED = 'failed';
    case IN_PROGRESS = 'in_progress';
    case OPEN = 'open';
    case PAID = 'paid';
    case PAID_PARTIALLY = 'paid_partially';
    case REFUNDED = 'refunded';
    case REFUNDED_PARTIALLY = 'refunded_partially';
    case REMINDED = 'reminded';
}
