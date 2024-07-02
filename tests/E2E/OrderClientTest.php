<?php

namespace ITB\ShopwareStoreApiClient\Tests\E2E;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;
use ITB\ShopwareStoreApiClient\CartClient;
use ITB\ShopwareStoreApiClient\Exception\RequestExceptionWithHttpStatusCode;
use ITB\ShopwareStoreApiClient\Model\Order;
use ITB\ShopwareStoreApiClient\Model\Order\OrderState;
use ITB\ShopwareStoreApiClient\OrderClient;
use ITB\ShopwareStoreApiClient\Request\Cart\LineItem\LineItemCollection;
use ITB\ShopwareStoreApiClient\Request\Cart\LineItem\ProductLineItem;
use ITB\ShopwareStoreApiClient\Request\Cart\LineItem\PromotionLineItem;
use ITB\ShopwareStoreApiClient\Request\Order\OrderMetadata;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreateCartClientHelper;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreateContextTokenProviderHelper;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreateOrderClientHelper;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreateSerializerHelper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;

final class OrderClientTest extends TestCase
{
    use ArraySubsetAsserts;
    use ResetShopwareTrait;

    protected function setUp(): void
    {
        $this->resetShopware($_ENV['SHOPWARE_URL']);
    }

    public static function cancelOrderProvider(): \Generator
    {
        $cartClient = CreateCartClientHelper::createCartClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);
        $orderClient = CreateOrderClientHelper::createOrderClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);
        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAuthenticatedUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN'],
            $_ENV['SHOPWARE_STORE_USER_EMAIL'],
            $_ENV['SHOPWARE_STORE_USER_PASSWORD']
        );

        $lineItemCollection = new LineItemCollection(new ProductLineItem(null, $_ENV['SHOPWARE_STORE_PRODUCT_ID_FOR_TEST'], 2));
        yield 'cancel open order' => [$cartClient, $lineItemCollection, $orderClient, $contextTokenProvider];
    }

    public static function createOrderFromCartProvider(): \Generator
    {
        $cartClient = CreateCartClientHelper::createCartClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);
        $orderClient = CreateOrderClientHelper::createOrderClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);
        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAuthenticatedUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN'],
            $_ENV['SHOPWARE_STORE_USER_EMAIL'],
            $_ENV['SHOPWARE_STORE_USER_PASSWORD']
        );
        $serializer = CreateSerializerHelper::createSerializer();

        $lineItemCollection = new LineItemCollection(new ProductLineItem(null, $_ENV['SHOPWARE_STORE_PRODUCT_ID_FOR_TEST'], 2));
        $orderMetadata = new OrderMetadata('Whoever reads this: go away from this doomed place.', null, null);
        $expectedOrderData = [
            'orderNumber' => '10000',
            'orderCustomer' => [
                'email' => $_ENV['SHOPWARE_STORE_USER_EMAIL'],
            ],
            'customerComment' => 'Whoever reads this: go away from this doomed place.',
            'lineItems' => [
                [
                    'type' => 'product',
                    'referencedId' => $_ENV['SHOPWARE_STORE_PRODUCT_ID_FOR_TEST'],
                ],
            ],
            'deliveries' => [
                [
                    'stateMachineState' => 'open',
                ],
            ],
            'transactions' => [
                [
                    'stateMachineState' => 'open',
                ],
            ],
        ];
        yield 'with product in cart / with order metadata' => [
            $cartClient,
            $lineItemCollection,
            $orderClient,
            $contextTokenProvider,
            $orderMetadata,
            $serializer,
            $expectedOrderData,
        ];

        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAuthenticatedUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN'],
            $_ENV['SHOPWARE_STORE_USER_EMAIL'],
            $_ENV['SHOPWARE_STORE_USER_PASSWORD']
        );
        $lineItemCollection = new LineItemCollection(new ProductLineItem(null, $_ENV['SHOPWARE_STORE_PRODUCT_ID_FOR_TEST'], 2));
        $expectedOrderData = [
            'customerComment' => null,
        ];
        yield 'with product in cart / without order metadata' => [
            $cartClient,
            $lineItemCollection,
            $orderClient,
            $contextTokenProvider,
            null,
            $serializer,
            $expectedOrderData,
        ];

        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAuthenticatedUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN'],
            $_ENV['SHOPWARE_STORE_USER_EMAIL'],
            $_ENV['SHOPWARE_STORE_USER_PASSWORD']
        );
        $lineItemCollection = new LineItemCollection(
            new ProductLineItem(null, $_ENV['SHOPWARE_STORE_PRODUCT_ID_FOR_TEST'], 2),
            new PromotionLineItem(null, $_ENV['SHOPWARE_STORE_PROMOTION_CODE_FOR_TEST'])
        );
        $expectedOrderData = [
            'lineItems' => [
                [
                    'type' => 'product',
                    'referencedId' => $_ENV['SHOPWARE_STORE_PRODUCT_ID_FOR_TEST'],
                ],
                [
                    'type' => 'promotion',
                    'referencedId' => $_ENV['SHOPWARE_STORE_PROMOTION_CODE_FOR_TEST'],
                ],
            ],
        ];
        yield 'with product and promotion in cart' => [
            $cartClient,
            $lineItemCollection,
            $orderClient,
            $contextTokenProvider,
            null,
            $serializer,
            $expectedOrderData,
        ];
    }

    public static function createOrderFromCartWithNoProductsProvider(): \Generator
    {
        $cartClient = CreateCartClientHelper::createCartClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);
        $orderClient = CreateOrderClientHelper::createOrderClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);
        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAuthenticatedUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN'],
            $_ENV['SHOPWARE_STORE_USER_EMAIL'],
            $_ENV['SHOPWARE_STORE_USER_PASSWORD']
        );

        $expectedErrors = [
            [
                'status' => '400',
                'code' => 'CHECKOUT__CART_EMPTY',
                'title' => 'Bad Request',
                'detail' => 'Cart is empty',
                'meta' => [
                    'parameters' => [],
                ],
            ],
        ];

        yield [$cartClient, $orderClient, $contextTokenProvider, $expectedErrors];
    }

    #[DataProvider('cancelOrderProvider')]
    public function testCancelOrder(
        CartClient $cartClient,
        LineItemCollection $lineItemCollection,
        OrderClient $orderClient,
        ContextTokenProvider $contextTokenProvider
    ): void {
        $cartClient->fetchOrCreateCart($contextTokenProvider, null);
        $cartClient->addLineItemsToCart($lineItemCollection, $contextTokenProvider, null);

        $order = $orderClient->createOrderFromCart(null, $contextTokenProvider, null);
        $orderId = $order->id;
        $orderState = $orderClient->cancelOrder($orderId, $contextTokenProvider, null);
        $this->assertEquals(OrderState::CANCELLED, $orderState);
    }

    /**
     * @param array<string, mixed> $expectedOrderData
     */
    #[DataProvider('createOrderFromCartProvider')]
    public function testCreateOrderFromCart(
        CartClient $cartClient,
        LineItemCollection $lineItemCollection,
        OrderClient $orderClient,
        ContextTokenProvider $contextTokenProvider,
        ?OrderMetadata $orderMetadata,
        Serializer $serializer,
        array $expectedOrderData
    ): void {
        $cartClient->fetchOrCreateCart($contextTokenProvider, null);
        if ($lineItemCollection->isEmpty() === false) {
            $cartClient->addLineItemsToCart($lineItemCollection, $contextTokenProvider, null);
        }

        $order = $orderClient->createOrderFromCart($orderMetadata, $contextTokenProvider, null);
        $this->assertInstanceOf(Order::class, $order);

        /** @var array<string, mixed> $orderData */
        $orderData = $serializer->normalize($order);
        $this->assertArraySubset($expectedOrderData, $orderData);
    }

    /**
     * @param array<string, mixed> $expectedErrors
     */
    #[DataProvider('createOrderFromCartWithNoProductsProvider')]
    public function testCreateOrderFromCartWithNoProducts(
        CartClient $cartClient,
        OrderClient $orderClient,
        ContextTokenProvider $contextTokenProvider,
        array $expectedErrors
    ): void {
        $cartClient->fetchOrCreateCart($contextTokenProvider, null);

        $this->expectException(RequestExceptionWithHttpStatusCode::class);
        try {
            $orderClient->createOrderFromCart(null, $contextTokenProvider, null);
        } catch (RequestExceptionWithHttpStatusCode $requestExceptionWithHttpStatusCode) {
            $this->assertNotNull($requestExceptionWithHttpStatusCode->getErrors());
            $this->assertArraySubset($expectedErrors, $requestExceptionWithHttpStatusCode->getErrors());

            throw $requestExceptionWithHttpStatusCode;
        }
    }
}
