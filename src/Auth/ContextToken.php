<?php

namespace ITB\ShopwareStoreApiClient\Auth;

final readonly class ContextToken
{
    public function __construct(
        private string $token
    ) {
    }

    /**
     * @param array<string, mixed> $headers
     * @return non-empty-array<string, mixed>
     */
    public function addToHeaders(array $headers): array
    {
        return [
            ...$headers,
            'sw-context-token' => $this->token,
        ];
    }
}
