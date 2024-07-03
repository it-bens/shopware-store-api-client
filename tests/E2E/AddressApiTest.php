<?php

namespace ITB\ShopwareStoreApiClient\Tests\E2E;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use ITB\ShopwareStoreApiClient\AddressClient;
use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;
use ITB\ShopwareStoreApiClient\ContextClient;
use ITB\ShopwareStoreApiClient\Model\Cart\CustomerAddress;
use ITB\ShopwareStoreApiClient\Model\Cart\CustomerAddressCollection;
use ITB\ShopwareStoreApiClient\Request\Address\AddressData;
use ITB\ShopwareStoreApiClient\Request\SearchCriteria;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreateAddressClientHelper;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreateContextClientHelper;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreateContextTokenProviderHelper;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreateNewCustomerAddressHelper;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreateSerializerHelper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;

final class AddressApiTest extends TestCase
{
    use ArraySubsetAsserts;
    use ResetShopwareTrait;

    protected function setUp(): void
    {
        $this->resetShopware($_ENV['SHOPWARE_URL']);
    }

    public static function changeCustomerDefaultAddressProvider(): \Generator
    {
        $addressClient = CreateAddressClientHelper::createAddressClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);
        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAuthenticatedUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN'],
            $_ENV['SHOPWARE_STORE_USER_EMAIL'],
            $_ENV['SHOPWARE_STORE_USER_PASSWORD']
        );
        $data = CreateNewCustomerAddressHelper::createNewCustomerAddress(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN'],
            $contextTokenProvider,
            '39ab383c14d64b45acfdf3e694b7a656',
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

        $contextClient = CreateContextClientHelper::createContextClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);

        yield [$addressClient, $contextTokenProvider, $data, $contextClient];
    }

    public static function createCustomerAddressProvider(): \Generator
    {
        $addressClient = CreateAddressClientHelper::createAddressClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);
        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAuthenticatedUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN'],
            $_ENV['SHOPWARE_STORE_USER_EMAIL'],
            $_ENV['SHOPWARE_STORE_USER_PASSWORD']
        );
        $serializer = CreateSerializerHelper::createSerializer();

        $data = CreateNewCustomerAddressHelper::createNewCustomerAddress(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN'],
            $contextTokenProvider,
            '39ab383c14d64b45acfdf3e694b7a656',
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

        $contextTokenProvider->resetContextToken();

        $expectedAddressData = [
            'firstName' => 'Homer',
            'lastName' => 'Simpson',
            'street' => 'Evergreen Terrace 742',
            'city' => 'Springfield',
            'company' => 'Compu-Global-Hyper-Mega-Net',
        ];

        yield [$addressClient, $data, $contextTokenProvider, $serializer, $expectedAddressData];
    }

    public static function fetchCustomerAddressesProvider(): \Generator
    {
        $addressClient = CreateAddressClientHelper::createAddressClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);
        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAuthenticatedUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN'],
            $_ENV['SHOPWARE_STORE_USER_EMAIL'],
            $_ENV['SHOPWARE_STORE_USER_PASSWORD']
        );
        $serializer = CreateSerializerHelper::createSerializer();

        $criteria = new SearchCriteria();
        $expectedAddressesData = [
            'elements' => [
                [
                    'salutation' => [
                        'salutationKey' => 'not_specified',
                    ],
                    'firstName' => 'Charles',
                    'lastName' => 'Martinet',
                    'street' => 'Mushroom Kingdom',
                    'zipcode' => '12345',
                    'city' => 'Nintendo City',
                    'country' =>
                        [
                            'iso' => 'DE',
                        ],
                ],
            ],
        ];

        yield [$addressClient, $criteria, $contextTokenProvider, $serializer, $expectedAddressesData];
    }

    #[DataProvider('changeCustomerDefaultAddressProvider')]
    public function testChangeCustomerDefaultBillingAddress(
        AddressClient $addressClient,
        ContextTokenProvider $contextTokenProvider,
        AddressData $newAddressData,
        ContextClient $contextClient,
    ): void {
        $newAddress = $addressClient->createCustomerAddress($newAddressData, $contextTokenProvider, null);
        $addressClient->changeCustomerDefaultBillingAddress($newAddress->address->id, $contextTokenProvider, null);
        $context = $contextClient->fetchCurrentContext($contextTokenProvider, null);
        $this->assertEquals($newAddress->address->id, $context->customer?->defaultBillingAddressId);
    }

    #[DataProvider('changeCustomerDefaultAddressProvider')]
    public function testChangeCustomerDefaultShippingAddress(
        AddressClient $addressClient,
        ContextTokenProvider $contextTokenProvider,
        AddressData $newAddressData,
        ContextClient $contextClient,
    ): void {
        $newAddress = $addressClient->createCustomerAddress($newAddressData, $contextTokenProvider, null);
        $addressClient->changeCustomerDefaultShippingAddress($newAddress->address->id, $contextTokenProvider, null);
        $context = $contextClient->fetchCurrentContext($contextTokenProvider, null);
        $this->assertEquals($newAddress->address->id, $context->customer?->defaultShippingAddressId);
    }

    /**
     * @param array<string, mixed> $expectedAddressData
     */
    #[DataProvider('createCustomerAddressProvider')]
    public function testCreateCustomerAddress(
        AddressClient $addressClient,
        AddressData $data,
        ContextTokenProvider $contextTokenProvider,
        Serializer $serializer,
        array $expectedAddressData
    ): void {
        $newAddress = $addressClient->createCustomerAddress($data, $contextTokenProvider, null);
        $this->assertInstanceOf(CustomerAddress::class, $newAddress);

        /** @var array<string, mixed> $addressData */
        $addressData = $serializer->normalize($newAddress);
        $this->assertArraySubset($expectedAddressData, $addressData);
    }

    /**
     * @param array<string, mixed> $expectedAddressesData
     */
    #[DataProvider('fetchCustomerAddressesProvider')]
    public function testFetchCustomerAddresses(
        AddressClient $addressClient,
        SearchCriteria $criteria,
        ContextTokenProvider $contextTokenProvider,
        Serializer $serializer,
        array $expectedAddressesData
    ): void {
        $addresses = $addressClient->fetchCustomerAddresses($criteria, $contextTokenProvider, null);
        $this->assertInstanceOf(CustomerAddressCollection::class, $addresses);
        $this->assertCount(count($expectedAddressesData), $addresses->elements);

        /** @var array<string, mixed> $addressesData */
        $addressesData = $serializer->normalize($addresses);
        $this->assertArraySubset($expectedAddressesData, $addressesData);
    }
}
