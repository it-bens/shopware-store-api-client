<?php

namespace ITB\ShopwareStoreApiClient\Tests\E2E\Helper;

use ITB\ShopwareStoreApiClient\ModelNormalizer\ContextSourceNormalizer;
use ITB\ShopwareStoreApiClient\ModelNormalizer\CustomerAddressNormalizer;
use ITB\ShopwareStoreApiClient\ModelNormalizer\DeliveryStateNormalizer;
use ITB\ShopwareStoreApiClient\ModelNormalizer\OrderStateNormalizer;
use ITB\ShopwareStoreApiClient\ModelNormalizer\TransactionStateNormalizer;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final readonly class CreateSerializerHelper
{
    public static function createSerializer(): Serializer
    {
        $encoders = [new JsonEncoder()];

        $phpDocExtractor = new PhpDocExtractor();
        $reflectionExtractor = new ReflectionExtractor();
        $propertyInfoExtractor = new PropertyInfoExtractor(
            listExtractors: [$reflectionExtractor],
            typeExtractors: [$phpDocExtractor, $reflectionExtractor],
            descriptionExtractors: [$phpDocExtractor],
            accessExtractors: [$reflectionExtractor],
            initializableExtractors: [$reflectionExtractor]
        );

        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader());
        $discriminator = new ClassDiscriminatorFromClassMetadata($classMetadataFactory);

        $customerAddressNormalizer = new CustomerAddressNormalizer();
        $orderStateNormalizer = new OrderStateNormalizer();
        $deliveryStateNormalizer = new DeliveryStateNormalizer();
        $transactionStateNormalizer = new TransactionStateNormalizer();
        $contextSourceNormalizer = new ContextSourceNormalizer();
        $objectNormalizer = new ObjectNormalizer(
            classMetadataFactory: $classMetadataFactory,
            propertyAccessor: PropertyAccess::createPropertyAccessor(),
            propertyTypeExtractor: $propertyInfoExtractor,
            classDiscriminatorResolver: $discriminator
        );
        $normalizers = [
            $customerAddressNormalizer,
            $orderStateNormalizer,
            $deliveryStateNormalizer,
            $transactionStateNormalizer,
            $contextSourceNormalizer,
            new BackedEnumNormalizer(),
            new ArrayDenormalizer(),
            $objectNormalizer,
        ];

        $serializer = new Serializer($normalizers, $encoders);
        $customerAddressNormalizer->setDenormalizer($serializer);
        $customerAddressNormalizer->setNormalizer($serializer);

        $orderStateNormalizer->setDenormalizer($serializer);
        $deliveryStateNormalizer->setDenormalizer($serializer);
        $transactionStateNormalizer->setDenormalizer($serializer);

        return $serializer;
    }
}
