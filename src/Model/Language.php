<?php

namespace ITB\ShopwareStoreApiClient\Model;

final readonly class Language
{
    public function __construct(
        public string $id,
        public string $name,
        public string $localeCode,
        public string $localeName,
        public string $localeTerritory,
    ) {
    }
}
