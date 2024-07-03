<?php

namespace ITB\ShopwareStoreApiClient;

use ITB\ShopwareStoreApiClient\Auth\AccessTokenProvider;
use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;
use ITB\ShopwareStoreApiClient\Language\LanguageIdProvider;
use Nyholm\Psr7\Request;
use Psr\Http\Message\RequestInterface;

final readonly class RequestBuilder implements RequestBuilderInterface
{
    public function buildRequest(
        string $httpMethod,
        string $url,
        ?array $data,
        AccessTokenProvider $accessTokenProvider,
        ?ContextTokenProvider $contextTokenProvider,
        ?LanguageIdProvider $languageIdProvider
    ): RequestInterface {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        $headers = $accessTokenProvider->provideAccessToken()
            ->addToHeaders($headers);
        if ($contextTokenProvider instanceof ContextTokenProvider) {
            $headers = $contextTokenProvider->provideContextToken()
                ->addToHeaders($headers);
        }

        if ($languageIdProvider instanceof LanguageIdProvider) {
            $headers = $languageIdProvider->provideLanguageId()
                ->addToHeaders($headers);
        }

        /** @var string|null $body */
        $body = $data !== null ? json_encode($data) : null;

        return new Request($httpMethod, $url, $headers, $body);
    }
}
