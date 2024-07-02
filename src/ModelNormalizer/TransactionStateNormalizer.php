<?php

namespace ITB\ShopwareStoreApiClient\ModelNormalizer;

use ITB\ShopwareStoreApiClient\Model\Order\Transaction\TransactionState;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class TransactionStateNormalizer implements DenormalizerAwareInterface, DenormalizerInterface
{
    use DenormalizerAwareTrait;

    private const DENORMALIZER_ALREADY_CALLED = 'TRANSACTION_STATE_DENORMALIZER_ALREADY_CALLED';

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

        $technicalName = $data['technicalName'] ?? null;
        if (\is_string($technicalName) === false) {
            throw NotNormalizableValueException::createForUnexpectedDataType(
                sprintf('The data contains no value for key "%s".', 'technicalName'),
                $data,
                ['non-empty-string'],
                isset($context['deserialization_path']) ? $context['deserialization_path'] . '.technicalName' : null
            );
        }

        $data = $technicalName;

        try {
            return $this->denormalizer->denormalize($data, TransactionState::class, $format, $context);
        } catch (\Throwable $throwable) {
            throw NotNormalizableValueException::createForUnexpectedDataType(
                $throwable->getMessage(),
                $data,
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
            TransactionState::class => false,
        ];
    }

    /**
     * @param array{TRANSACTION_STATE_DENORMALIZER_ALREADY_CALLED?: bool} $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        if ($type !== TransactionState::class) {
            return false;
        }

        return ! isset($context[self::DENORMALIZER_ALREADY_CALLED]);
    }
}
