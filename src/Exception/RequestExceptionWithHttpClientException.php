<?php

namespace ITB\ShopwareStoreApiClient\Exception;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;

final class RequestExceptionWithHttpClientException extends \RuntimeException implements RequestExceptionInterface
{
    private const MESSAGE_WITH_DATA_TEMPLATE = 'The %s request to the URI "%s" failed. The headers were: [%s]. The body was "%s". The error message was: %s';

    private const MESSAGE_WITHOUT_DATA_TEMPLATE = 'The %s request to the URI "%s" failed. The headers were: [%s]. The body was empty. The error message was: %s';

    public function __construct(
        ClientExceptionInterface $previous,
        private readonly RequestInterface $request
    ) {
        $method = $this->request->getMethod();
        $uri = $this->request->getUri();
        $headers = $this->request->getHeaders();

        $message = sprintf(self::MESSAGE_WITHOUT_DATA_TEMPLATE, $method, $uri, json_encode($headers), $previous->getMessage());

        $body = $this->request->getBody()
            ->getContents();
        if ($body !== '' && $body !== '0') {
            $message = sprintf(self::MESSAGE_WITH_DATA_TEMPLATE, $method, $uri, json_encode($headers), $body, $previous->getMessage());
        }

        parent::__construct($message, 0, $previous);
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}
