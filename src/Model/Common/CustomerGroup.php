<?php

namespace ITB\ShopwareStoreApiClient\Model\Common;

final readonly class CustomerGroup
{
    public function __construct(
        public string $id,
        public string $name,
        public bool $displayGross,
        public bool $registrationActive,
        public ?string $registrationTitle,
        public ?string $registrationIntroduction,
        public ?bool $registrationOnlyCompanyRegistration,
        public ?string $registrationSeoMetaDescription
    ) {
    }
}
