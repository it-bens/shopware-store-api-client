<?php

namespace ITB\ShopwareStoreApiClient\Model;

use ITB\ShopwareStoreApiClient\Model\Address\Country;
use ITB\ShopwareStoreApiClient\Model\Address\CountryState;
use ITB\ShopwareStoreApiClient\Model\Address\Salutation;

final readonly class Address
{
    public function __construct(
        public string $id,
        public ?string $salutationId,
        public ?Salutation $salutation,
        public ?string $title,
        public string $firstName,
        public string $lastName,
        public string $street,
        public ?string $zipcode,
        public ?string $city,
        public ?string $additionalAddressLine1,
        public ?string $additionalAddressLine2,
        public string $countryId,
        public ?Country $country,
        public ?string $countryStateId,
        public ?CountryState $countryState,
        public ?string $company,
        public ?string $department,
        public ?string $phoneNumber,
    ) {
    }
}
