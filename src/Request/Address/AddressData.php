<?php

namespace ITB\ShopwareStoreApiClient\Request\Address;

final readonly class AddressData
{
    public function __construct(
        private ?string $id,
        private string $customerId,
        private string $countryId,
        private ?string $countryStateId,
        private string $salutationId,
        private ?string $title,
        private string $firstName,
        private string $lastName,
        private string $street,
        private ?string $zipcode,
        private string $city,
        private ?string $additionalAddressLine1,
        private ?string $additionalAddressLine2,
        private ?string $company,
        private ?string $department,
        private ?string $phoneNumber,
    ) {
    }

    /**
     * @return array{
     *     id: string|null,
     *     customerId: string,
     *     countryId: string,
     *     countryStateId: string|null,
     *     salutationId: string,
     *     title: string|null,
     *     firstName: string,
     *     lastName: string,
     *     street: string,
     *     zipcode: string|null,
     *     city: string,
     *     additionalAddressLine1: string|null,
     *     additionalAddressLine2: string|null,
     *     company: string|null,
     *     department: string|null,
     *     phoneNumber: string|null,
     * }
     */
    public function toPayload(): array
    {
        return [
            'id' => $this->id,
            'customerId' => $this->customerId,
            'countryId' => $this->countryId,
            'countryStateId' => $this->countryStateId,
            'salutationId' => $this->salutationId,
            'title' => $this->title,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'street' => $this->street,
            'zipcode' => $this->zipcode,
            'city' => $this->city,
            'additionalAddressLine1' => $this->additionalAddressLine1,
            'additionalAddressLine2' => $this->additionalAddressLine2,
            'company' => $this->company,
            'department' => $this->department,
            'phoneNumber' => $this->phoneNumber,
        ];
    }
}
