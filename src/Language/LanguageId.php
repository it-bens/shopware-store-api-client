<?php

namespace ITB\ShopwareStoreApiClient\Language;

final readonly class LanguageId
{
    public function __construct(
        private string $id
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
            'sw-language-id' => $this->id,
        ];
    }
}
