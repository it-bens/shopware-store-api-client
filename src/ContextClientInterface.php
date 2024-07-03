<?php

namespace ITB\ShopwareStoreApiClient;

use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;
use ITB\ShopwareStoreApiClient\Language\LanguageIdProvider;
use ITB\ShopwareStoreApiClient\Model\Context;
use ITB\ShopwareStoreApiClient\Request\Context\ContextData;

interface ContextClientInterface
{
    public function fetchCurrentContext(ContextTokenProvider $contextTokenProvider, ?LanguageIdProvider $languageIdProvider): Context;

    public function updateCurrentContext(
        ContextData $data,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): void;
}
