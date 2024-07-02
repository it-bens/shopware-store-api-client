<?php

namespace ITB\ShopwareStoreApiClient;

use ITB\ShopwareStoreApiClient\Exception\NotDeserializableResponseException;
use ITB\ShopwareStoreApiClient\Exception\RequestExceptionWithHttpStatusCode;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface as SerializerException;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class ResponseProcessor implements ResponseProcessorInterface
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @template T of object
     * @param class-string<T> $type
     * @return T
     */
    public function processResponse(string $type, RequestInterface $request, ResponseInterface $response, int $expectedStatusCode): object
    {
        $content = $response->getBody()
            ->getContents();
        if ($response->getStatusCode() !== $expectedStatusCode) {
            throw new RequestExceptionWithHttpStatusCode($response->getStatusCode(), $expectedStatusCode, $request, $content);
        }

        try {
            /** @var T $deserialized */
            $deserialized = $this->serializer->deserialize($content, $type, 'json', [
                'keyType' => ['int', 'string'],
            ]);
        } catch (SerializerException $serializerException) {
            throw new NotDeserializableResponseException($serializerException, $request, $response, $content);
        }

        return $deserialized;
    }
}
