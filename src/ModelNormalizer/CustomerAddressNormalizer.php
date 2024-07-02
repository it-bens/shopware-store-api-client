<?php

namespace ITB\ShopwareStoreApiClient\ModelNormalizer;

use ITB\ShopwareStoreApiClient\Model\Cart\CustomerAddress;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class CustomerAddressNormalizer implements DenormalizerAwareInterface, DenormalizerInterface, NormalizerAwareInterface, NormalizerInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;

    private const DENORMALIZER_ALREADY_CALLED = 'CUSTOMER_ADDRESS_DENORMALIZER_ALREADY_CALLED';

    private const NORMALIZER_ALREADY_CALLED = 'CUSTOMER_ADDRESS_NORMALIZER_ALREADY_CALLED';

    /**
     * @param array{deserialization_path?: string} $context
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $context[self::DENORMALIZER_ALREADY_CALLED] = true;

        if (! \is_array($data)) {
            throw NotNormalizableValueException::createForUnexpectedDataType(
                sprintf('Data expected to be "%s", "%s" given.', 'array', get_debug_type($data)),
                $data,
                ['array'],
                $context['deserialization_path'] ?? null
            );
        }

        $customerId = $data['customerId'] ?? null;
        if (\is_string($customerId) === false) {
            throw NotNormalizableValueException::createForUnexpectedDataType(
                sprintf('The data contains no value for key "%s".', 'customerId'),
                $data,
                ['non-empty-string'],
                isset($context['deserialization_path']) ? $context['deserialization_path'] . '.customerId' : null
            );
        }

        $addressData = $data;
        unset($addressData['customerId']);
        $modifiedData = [
            'customerId' => $customerId,
            'address' => $addressData,
        ];

        try {
            return $this->denormalizer->denormalize($modifiedData, CustomerAddress::class, $format, $context);
        } catch (\Throwable $throwable) {
            throw NotNormalizableValueException::createForUnexpectedDataType(
                $throwable->getMessage(),
                $modifiedData,
                ['unknown'],
                $context['deserialization_path'] ?? null,
                false,
                $throwable->getCode(),
                $throwable
            );
        }
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            CustomerAddress::class => false,
        ];
    }

    /**
     * @param array<string, mixed> $context
     * @return array<string, mixed>
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        $context[self::NORMALIZER_ALREADY_CALLED] = true;

        if (! $object instanceof CustomerAddress) {
            throw new InvalidArgumentException(sprintf('The object must be an instance of "%s".', CustomerAddress::class));
        }

        /** @var array{address: array<string, mixed>} $normalizedData */
        $normalizedData = $this->normalizer->normalize($object, $format, $context);
        $addressData = $normalizedData['address'];
        unset($normalizedData['address']);

        return array_merge($normalizedData, $addressData);
    }

    /**
     * @param array{CUSTOMER_ADDRESS_DENORMALIZER_ALREADY_CALLED?: bool} $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        if ($type !== CustomerAddress::class) {
            return false;
        }

        return ! isset($context[self::DENORMALIZER_ALREADY_CALLED]);
    }

    /**
     * @param array{CUSTOMER_ADDRESS_NORMALIZER_ALREADY_CALLED?: bool} $context
     */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        if (! $data instanceof CustomerAddress) {
            return false;
        }

        return ! isset($context[self::NORMALIZER_ALREADY_CALLED]);
    }
}
