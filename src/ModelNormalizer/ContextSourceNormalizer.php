<?php

namespace ITB\ShopwareStoreApiClient\ModelNormalizer;

use ITB\ShopwareStoreApiClient\Model\Context\ContextSource;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class ContextSourceNormalizer implements DenormalizerAwareInterface, DenormalizerInterface
{
    use DenormalizerAwareTrait;

    private const DENORMALIZER_ALREADY_CALLED = 'CONTEXT_SOURCE_DENORMALIZER_ALREADY_CALLED';

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

        $type = $data['type'] ?? null;
        if (\is_string($type) === false) {
            throw NotNormalizableValueException::createForUnexpectedDataType(
                sprintf('The data contains no value for key "%s".', 'type'),
                $data,
                ['non-empty-string'],
                isset($context['deserialization_path']) ? $context['deserialization_path'] . '.technicalName' : null
            );
        }

        $data = $type;

        try {
            return $this->denormalizer->denormalize($data, ContextSource::class, $format, $context);
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
            ContextSource::class => false,
        ];
    }

    /**
     * @param array{CONTEXT_SOURCE_DENORMALIZER_ALREADY_CALLED?: bool} $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        if ($type !== ContextSource::class) {
            return false;
        }

        return ! isset($context[self::DENORMALIZER_ALREADY_CALLED]);
    }
}
