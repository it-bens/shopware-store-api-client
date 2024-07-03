<?php

namespace ITB\ShopwareStoreApiClient\Model\Common\SalesChannel;

use ITB\ShopwareStoreApiClient\Model\Currency;
use ITB\ShopwareStoreApiClient\Model\Language;

final readonly class Domain
{
    public function __construct(
        public string $id,
        public string $salesChannelId,
        public string $url,
        public string $languageId,
        public ?Language $language,
        public string $currencyId,
        public ?Currency $currency,
        public string $snippetSetId,
        public ?string $salesChannelDefaultHreflang,
        public bool $hreflangUseOnlyLocale
    ) {
    }
}
