<?php

namespace ITB\ShopwareStoreApiClient\Model\Cart\LineItem;

use ITB\ShopwareStoreApiClient\Model\Cart\LineItem\PriceDefinition\CurrencyPriceDefinition;
use ITB\ShopwareStoreApiClient\Model\Cart\LineItem\PriceDefinition\PercentagePriceDefinition;
use ITB\ShopwareStoreApiClient\Model\Cart\LineItem\PriceDefinition\QuantityPriceDefinition;
use Symfony\Component\Serializer\Attribute\DiscriminatorMap;

#[DiscriminatorMap(typeProperty: 'type', mapping: [
    'currency-price' => CurrencyPriceDefinition::class,
    'percentage' => PercentagePriceDefinition::class,
    'quantity' => QuantityPriceDefinition::class,
])]
interface PriceDefinition
{
    public function getType(): string;
}
