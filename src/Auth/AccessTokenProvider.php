<?php

namespace ITB\ShopwareStoreApiClient\Auth;

interface AccessTokenProvider
{
    public function provideAccessToken(): AccessToken;
}
