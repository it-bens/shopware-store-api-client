<?php

namespace ITB\ShopwareStoreApiClient\Auth;

interface ContextTokenProvider
{
    public function provideContextToken(): ContextToken;

    public function resetContextToken(): void;
}
