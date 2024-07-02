<?php

namespace ITB\ShopwareStoreApiClient\Exception;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

final class NotDeserializableResponseException extends \RuntimeException implements ResponseException
{
    private const MESSAGE_TEMPLATE = 'The response to the request to the URI "%s" could not be deserialized. The response content was "%s". The error message was: %s';

    public function __construct(
        ExceptionInterface $previous,
        RequestInterface $request,
        private readonly ResponseInterface $response,
        private readonly string $content
    ) {
        $uri = $request->getUri();

        $message = sprintf(self::MESSAGE_TEMPLATE, $uri, $this->content, $previous->getMessage());

        parent::__construct($message, 0, $previous);
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
