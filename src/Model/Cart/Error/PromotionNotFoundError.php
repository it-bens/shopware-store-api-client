<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart\Error;

use ITB\ShopwareStoreApiClient\Model\Cart\Error;

final readonly class PromotionNotFoundError implements Error
{
    public function __construct(
        public string $message,
        public int $code,
        public string $key,
        public int $level,
        public string $messageKey,
        public string $promotionCode,
    ) {
    }

    public function getMessageKey(): string
    {
        return $this->messageKey;
    }

    public function isError(): bool
    {
        return $this->level === Error::LEVEL_ERROR;
    }

    public function isNotice(): bool
    {
        return $this->level === Error::LEVEL_NOTICE;
    }

    public function isWarning(): bool
    {
        return $this->level === Error::LEVEL_WARNING;
    }
}
