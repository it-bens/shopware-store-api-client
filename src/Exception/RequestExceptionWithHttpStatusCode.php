<?php

namespace ITB\ShopwareStoreApiClient\Exception;

use Psr\Http\Message\RequestInterface;

final class RequestExceptionWithHttpStatusCode extends \RuntimeException implements RequestExceptionInterface
{
    private const MESSAGE_WITH_DATA_TEMPLATE = 'The %s request to the URI "%s" failed. The headers were: [%s]. The body was "%s". The status code was %s, but expected was %s.';

    private const MESSAGE_WITHOUT_DATA_TEMPLATE = 'The %s request to the URI "%s" failed. The headers were: [%s]. The body was empty. The status code was %s, but expected was %s.';

    public function __construct(
        int $statusCode,
        int $expectedStatusCode,
        private readonly RequestInterface $request,
        private readonly string $content
    ) {
        $method = $this->request->getMethod();
        $uri = $this->request->getUri();
        $headers = $this->request->getHeaders();

        $message = sprintf(
            self::MESSAGE_WITHOUT_DATA_TEMPLATE,
            $method,
            $uri,
            json_encode($headers),
            (string) $statusCode,
            (string) $expectedStatusCode
        );

        if ($this->content !== '' && $this->content !== '0') {
            $message = sprintf(
                self::MESSAGE_WITH_DATA_TEMPLATE,
                $method,
                $uri,
                json_encode($headers),
                $this->content,
                (string) $statusCode,
                (string) $expectedStatusCode
            );
        }

        parent::__construct($message);
    }

    /**
     * @return array{
     *     errors?: array{
     *         status: string,
     *         code: string,
     *         title: string,
     *         meta: array{
     *           parameters: array<string, string>
     *         }
     *     }
     * }|null
     */
    public function getErrors(): ?array
    {
        $parsedContent = json_decode($this->content, true);
        if (\is_array($parsedContent) === false) {
            return null;
        }

        /**
         * @var array{
         *     errors?: array{
         *         status: string,
         *         code: string,
         *         title: string,
         *         meta: array{
         *           parameters: array<string, string>
         *         }
         *     }
         * } $parsedContent
         */

        if (\array_key_exists('errors', $parsedContent) === false) {
            return null;
        }

        return $parsedContent['errors'];
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}
