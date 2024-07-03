<?php

namespace ITB\ShopwareStoreApiClient\Tests\E2E\Helper;

use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;
use ITB\ShopwareStoreApiClient\Request\Address\AddressData;
use ITB\ShopwareStoreApiClient\Request\SearchCriteria;

final readonly class CreateNewCustomerAddressHelper
{
    public static function createNewCustomerAddress(
        string $shopwareStoreUrl,
        string $shopwareStoreAccessToken,
        ContextTokenProvider $contextTokenProvider,
        string $customerId,
        ?string $title,
        string $firstName,
        string $lastName,
        string $street,
        ?string $zipcode,
        string $city,
        ?string $additionalAddressLine1,
        ?string $additionalAddressLine2,
        ?string $company,
        ?string $department,
        ?string $phoneNumber
    ): AddressData {
        $addressClient = CreateAddressClientHelper::createAddressClient($shopwareStoreUrl, $shopwareStoreAccessToken);
        $addresses = $addressClient->fetchCustomerAddresses(new SearchCriteria(), $contextTokenProvider, null);
        $contextTokenProvider->resetContextToken();

        /** @var string $countryId */
        $countryId = $addresses->elements[0]->address->country?->id;
        /** @var string $salutationId */
        $salutationId = $addresses->elements[0]->address->salutation?->id;

        return new AddressData(
            null,
            $customerId,
            $countryId,
            null,
            $salutationId,
            $title,
            $firstName,
            $lastName,
            $street,
            $zipcode,
            $city,
            $additionalAddressLine1,
            $additionalAddressLine2,
            $company,
            $department,
            $phoneNumber,
        );
    }
}
