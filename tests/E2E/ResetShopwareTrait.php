<?php

namespace ITB\ShopwareStoreApiClient\Tests\E2E;

use Symfony\Component\HttpClient\HttpClient;

trait ResetShopwareTrait
{
    private function resetShopware(string $shopwareUrl): void
    {
        $httpClient = HttpClient::create();
        $httpClient->request('GET', $shopwareUrl . '/reset');
    }
}
