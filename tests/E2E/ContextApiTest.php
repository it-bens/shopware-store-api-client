<?php

namespace ITB\ShopwareStoreApiClient\Tests\E2E;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use ITB\ShopwareStoreApiClient\AddressClient;
use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;
use ITB\ShopwareStoreApiClient\ContextClient;
use ITB\ShopwareStoreApiClient\Model\Context;
use ITB\ShopwareStoreApiClient\Request\Address\AddressData;
use ITB\ShopwareStoreApiClient\Request\Context\ContextData;
use ITB\ShopwareStoreApiClient\Request\SearchCriteria;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreateAddressClientHelper;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreateContextClientHelper;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreateContextTokenProviderHelper;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreateSerializerHelper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;

final class ContextApiTest extends TestCase
{
    use ArraySubsetAsserts;
    use ResetShopwareTrait;

    protected function setUp(): void
    {
        $this->resetShopware($_ENV['SHOPWARE_URL']);
    }

    public static function fetchCurrentContextProvider(): \Generator
    {
        $contextClient = CreateContextClientHelper::createContextClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);
        $serializer = CreateSerializerHelper::createSerializer();
        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAnonymousUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN'],
        );

        $expectedContextData = [
            'customer' => null,
            'salesChannel' => [
                'active' => true,
            ],
            'currency' => [
                'isoCode' => 'EUR',
            ],
            'currentCustomerGroup' => [],
            'paymentMethod' => [
                'technicalName' => 'payment_cashpayment',
            ],
            'shippingMethod' => [
                'name' => 'Standard',
            ],
            'shippingLocation' => [
                'country' => [
                    'iso' => 'DE',
                ],
            ],
            'context' => [
                'scope' => 'user',
                'source' => 'sales-channel',
                'taxState' => 'gross',
            ],
            'itemRounding' => [
                'decimals' => 2,
                'interval' => 0.01,
                'roundForNet' => true,
            ],
            'totalRounding' => [
                'decimals' => 2,
                'interval' => 0.01,
                'roundForNet' => true,
            ],
        ];

        yield 'with anonymous user' => [$contextClient, $contextTokenProvider, $serializer, $expectedContextData];

        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAuthenticatedUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN'],
            $_ENV['SHOPWARE_STORE_USER_EMAIL'],
            $_ENV['SHOPWARE_STORE_USER_PASSWORD']
        );

        $expectedContextData['paymentMethod'] = [
            'technicalName' => 'payment_prepayment',
        ];
        $expectedContextData['customer'] = [
            'customerNumber' => '797869',
            'guest' => false,
            'accountType' => 'private',
            'email' => $_ENV['SHOPWARE_STORE_USER_EMAIL'],
            'firstName' => 'Charles',
            'lastName' => 'Martinet',
            'active' => true,
        ];

        yield 'with authenticated user' => [$contextClient, $contextTokenProvider, $serializer, $expectedContextData];
    }

    /**
     * @param array<string, mixed> $expectedContextData
     */
    #[DataProvider('fetchCurrentContextProvider')]
    public function testFetchCurrentContext(
        ContextClient $contextClient,
        ContextTokenProvider $contextTokenProvider,
        Serializer $serializer,
        array $expectedContextData
    ): void {
        $context = $contextClient->fetchCurrentContext($contextTokenProvider, null);
        $this->assertInstanceOf(Context::class, $context);

        /** @var array<string, mixed> $contextData */
        $contextData = $serializer->normalize($context);
        $this->assertArraySubset($expectedContextData, $contextData);
    }

    #[DataProvider('updateCurrentContextProvider')]
    public function testUpdateCurrentContext(
        ContextClient $contextClient,
        AddressClient $addressClient,
        AddressData $addressData,
        ContextTokenProvider $contextTokenProvider
    ): void {
        $newAddress = $addressClient->createCustomerAddress($addressData, $contextTokenProvider, null);
        $contextData = new ContextData(billingAddressId: $newAddress->address->id, shippingAddressId: $newAddress->address->id);

        $contextClient->updateCurrentContext($contextData, $contextTokenProvider, null);
        $context = $contextClient->fetchCurrentContext($contextTokenProvider, null);
        $this->assertInstanceOf(Context::class, $context);
        $this->assertEquals($newAddress->address->id, $context->customer?->activeBillingAddress?->address->id);
        $this->assertEquals($newAddress->address->id, $context->customer?->activeShippingAddress?->address->id);
    }

    public static function updateCurrentContextProvider(): \Generator
    {
        $contextClient = CreateContextClientHelper::createContextClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);
        $addressClient = CreateAddressClientHelper::createAddressClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);
        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAuthenticatedUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN'],
            $_ENV['SHOPWARE_STORE_USER_EMAIL'],
            $_ENV['SHOPWARE_STORE_USER_PASSWORD']
        );

        $address = $addressClient->fetchCustomerAddresses(new SearchCriteria(), $contextTokenProvider, null);
        $contextTokenProvider->resetContextToken();

        /** @var string $countryId */
        $countryId = $address->elements[0]->address->country?->id;
        /** @var string $salutationId */
        $salutationId = $address->elements[0]->address->salutation?->id;

        $addressData = new AddressData(
            null,
            '39ab383c14d64b45acfdf3e694b7a656',
            $countryId,
            null,
            $salutationId,
            null,
            'Homer',
            'Simpson',
            'Evergreen Terrace 742',
            null,
            'Springfield',
            'The house without number',
            null,
            'Compu-Global-Hyper-Mega-Net',
            null,
            null,
        );

        yield 'with authenticated user' => [$contextClient, $addressClient, $addressData, $contextTokenProvider];
    }
}
