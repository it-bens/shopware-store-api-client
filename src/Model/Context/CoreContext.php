<?php

namespace ITB\ShopwareStoreApiClient\Model\Context;

use ITB\ShopwareStoreApiClient\Model\Common\CashRoundingConfig;
use ITB\ShopwareStoreApiClient\Model\Common\TaxStatus;

final readonly class CoreContext
{
    public function __construct(
        public string $versionId,
        public string $currencyId,
        public int $currencyFactor,
        public ContextScope $scope,
        public ContextSource $source,
        public TaxStatus $taxState,
        public CashRoundingConfig $rounding,
    ) {
    }
}
