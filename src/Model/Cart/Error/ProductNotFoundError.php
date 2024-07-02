<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart\Error;

use ITB\ShopwareStoreApiClient\Model\Cart\Error;

final readonly class ProductNotFoundError implements Error
{
    public function __construct(
        public string $message,
        public int $code,
        public string $key,
        public int $level,
        public string $messageKey,
        public string $id,
        public int $line
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
