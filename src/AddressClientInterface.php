<?php

namespace ITB\ShopwareStoreApiClient;

use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;
use ITB\ShopwareStoreApiClient\Language\LanguageIdProvider;
use ITB\ShopwareStoreApiClient\Model\Cart\CustomerAddress;
use ITB\ShopwareStoreApiClient\Model\Cart\CustomerAddressCollection;
use ITB\ShopwareStoreApiClient\Request\Address\AddressData;
use ITB\ShopwareStoreApiClient\Request\SearchCriteria;

interface AddressClientInterface
{
    public function changeCustomerDefaultBillingAddress(
        string $addressId,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): void;

    public function changeCustomerDefaultShippingAddress(
        string $addressId,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): void;

    public function createCustomerAddress(
        AddressData $data,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): CustomerAddress;

    public function deleteCustomerAddress(
        string $addressId,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): void;

    public function fetchCustomerAddresses(
        SearchCriteria $criteria,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): CustomerAddressCollection;

    public function updateCustomerAddress(
        string $addressId,
        AddressData $data,
        ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): CustomerAddress;
}
