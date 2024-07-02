<?php

namespace ITB\ShopwareStoreApiClient\Tests\E2E;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use ITB\ShopwareStoreApiClient\Auth\ContextTokenProvider;
use ITB\ShopwareStoreApiClient\CartClient;
use ITB\ShopwareStoreApiClient\Model\Cart;
use ITB\ShopwareStoreApiClient\Request\Cart\LineItem\LineItemCollection;
use ITB\ShopwareStoreApiClient\Request\Cart\LineItem\ProductLineItem;
use ITB\ShopwareStoreApiClient\Request\Cart\LineItem\PromotionLineItem;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreateCartClientHelper;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreateContextTokenProviderHelper;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreateEmptyCartDataHelper;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreateProductLineItemDataHelper;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreatePromotionLineItemDataHelper;
use ITB\ShopwareStoreApiClient\Tests\E2E\Helper\CreateSerializerHelper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;

final class CartClientTest extends TestCase
{
    use ArraySubsetAsserts;
    use ResetShopwareTrait;

    protected function setUp(): void
    {
        $this->resetShopware($_ENV['SHOPWARE_URL']);
    }

    public static function addLineItemsToCartProvider(): \Generator
    {
        $cartClient = CreateCartClientHelper::createCartClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);
        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAnonymousUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']
        );
        $serializer = CreateSerializerHelper::createSerializer();

        $lineItemCollection = new LineItemCollection(new ProductLineItem(null, $_ENV['SHOPWARE_STORE_PRODUCT_ID_FOR_TEST'], 1));
        $lineItemData = [
            'lineItems' => [CreateProductLineItemDataHelper::createProductLineItemData($_ENV['SHOPWARE_STORE_PRODUCT_ID_FOR_TEST'], 1)],
        ];
        yield 'add product line item with quantity 1' => [
            $cartClient,
            $contextTokenProvider,
            $lineItemCollection,
            $serializer,
            $lineItemData,
        ];

        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAnonymousUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']
        );
        $lineItemCollection = new LineItemCollection(new ProductLineItem(null, $_ENV['SHOPWARE_STORE_PRODUCT_ID_FOR_TEST'], 2));
        $lineItemData = [
            'lineItems' => [CreateProductLineItemDataHelper::createProductLineItemData($_ENV['SHOPWARE_STORE_PRODUCT_ID_FOR_TEST'], 2)],
        ];
        yield 'add product line item with quantity 2' => [
            $cartClient,
            $contextTokenProvider,
            $lineItemCollection,
            $serializer,
            $lineItemData,
        ];

        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAnonymousUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']
        );
        $lineItemCollection = new LineItemCollection(
            new ProductLineItem(null, $_ENV['SHOPWARE_STORE_PRODUCT_ID_FOR_TEST'], 2),
            new PromotionLineItem(null, $_ENV['SHOPWARE_STORE_PROMOTION_CODE_FOR_TEST'])
        );
        $lineItemData = [
            'lineItems' => [
                CreateProductLineItemDataHelper::createProductLineItemData($_ENV['SHOPWARE_STORE_PRODUCT_ID_FOR_TEST'], 2),
                CreatePromotionLineItemDataHelper::createPromotionLineItemData($_ENV['SHOPWARE_STORE_PROMOTION_CODE_FOR_TEST']),
            ],
        ];
        yield 'add product line item and promotion line item' => [
            $cartClient,
            $contextTokenProvider,
            $lineItemCollection,
            $serializer,
            $lineItemData,
        ];

        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAnonymousUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']
        );
        $lineItemCollection = new LineItemCollection(new PromotionLineItem(null, $_ENV['SHOPWARE_STORE_PROMOTION_CODE_FOR_TEST']));
        $cartPromotionExtensionData = [
            'extensions' => [
                'cart-promotions' => [
                    'addedCodes' => [$_ENV['SHOPWARE_STORE_PROMOTION_CODE_FOR_TEST']],
                ],
            ],
        ];
        yield 'add promotion line item without a product line item' => [
            $cartClient,
            $contextTokenProvider,
            $lineItemCollection,
            $serializer,
            $cartPromotionExtensionData,
        ];
    }

    public static function deleteCartWithAuthenticatedUserProvider(): \Generator
    {
        $cartClient = CreateCartClientHelper::createCartClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);
        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAuthenticatedUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN'],
            $_ENV['SHOPWARE_STORE_USER_EMAIL'],
            $_ENV['SHOPWARE_STORE_USER_PASSWORD']
        );
        $productLineItemsToAddForTest = new LineItemCollection(new ProductLineItem(null, $_ENV['SHOPWARE_STORE_PRODUCT_ID_FOR_TEST'], 1));

        yield [$cartClient, $contextTokenProvider, $productLineItemsToAddForTest];
    }

    public static function deleteProductFromCartByProductIdProvider(): \Generator
    {
        $cartClient = CreateCartClientHelper::createCartClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);
        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAnonymousUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']
        );
        $serializer = CreateSerializerHelper::createSerializer();

        yield 'update product line item from quantity 1 to quantity 2' => [
            $cartClient,
            $contextTokenProvider,
            $_ENV['SHOPWARE_STORE_PRODUCT_ID_FOR_TEST'],
            $serializer,
            CreateEmptyCartDataHelper::createEmptyCartData(),
        ];
    }

    public static function fetchOrCreateCartWithAnonymousUserProvider(): \Generator
    {
        $cartClient = CreateCartClientHelper::createCartClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);
        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAnonymousUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']
        );
        $serializer = CreateSerializerHelper::createSerializer();

        yield 'with context token' => [$cartClient, $contextTokenProvider, $serializer, CreateEmptyCartDataHelper::createEmptyCartData()];
        yield 'without context token' => [$cartClient, null, $serializer, CreateEmptyCartDataHelper::createEmptyCartData()];
    }

    public static function fetchOrCreateCartWithAuthenticatedUserProvider(): \Generator
    {
        $cartClient = CreateCartClientHelper::createCartClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);
        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAuthenticatedUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN'],
            $_ENV['SHOPWARE_STORE_USER_EMAIL'],
            $_ENV['SHOPWARE_STORE_USER_PASSWORD']
        );

        yield [$cartClient, $contextTokenProvider];
    }

    /**
     * @param array<string, mixed> $expectedCartData
     */
    #[DataProvider('addLineItemsToCartProvider')]
    public function testAddLineItemsToCart(
        CartClient $cartClient,
        ?ContextTokenProvider $contextTokenProvider,
        LineItemCollection $lineItems,
        Serializer $serializer,
        array $expectedCartData
    ): void {
        $cartClient->fetchOrCreateCart($contextTokenProvider, null);
        $cartWithLineItems = $cartClient->addLineItemsToCart($lineItems, $contextTokenProvider, null);
        $this->assertInstanceOf(Cart::class, $cartWithLineItems);

        /** @var array<string, mixed> $cartData */
        $cartData = $serializer->normalize($cartWithLineItems);
        $this->assertArraySubset($expectedCartData, $cartData);
    }

    #[DataProvider('deleteCartWithAuthenticatedUserProvider')]
    public function testDeleteCartWithAuthenticatedUser(
        CartClient $cartClient,
        ContextTokenProvider $contextTokenProvider,
        LineItemCollection $lineItemsToAddForTest
    ): void {
        $cart = $cartClient->fetchOrCreateCart($contextTokenProvider, null);
        $cartWithProductLineItems = $cartClient->addLineItemsToCart($lineItemsToAddForTest, $contextTokenProvider, null);
        $this->assertNotSame($cart->price->rawTotal, $cartWithProductLineItems->price->rawTotal);

        $cartClient->deleteCart($contextTokenProvider);
        $newCart = $cartClient->fetchOrCreateCart($contextTokenProvider, null);
        $this->assertEqualsWithDelta(0.0, $newCart->price->rawTotal, PHP_FLOAT_EPSILON);
    }

    /**
     * @param array<string, mixed> $expectedCartData
     */
    #[DataProvider('deleteProductFromCartByProductIdProvider')]
    public function testDeleteProductFromCartByProductId(
        CartClient $cartClient,
        ?ContextTokenProvider $contextTokenProvider,
        string $productId,
        Serializer $serializer,
        array $expectedCartData
    ): void {
        $cartClient->fetchOrCreateCart($contextTokenProvider, null);
        $lineItems = new LineItemCollection(new ProductLineItem(null, $productId, 1));
        $cartWithLineItems = $cartClient->addLineItemsToCart($lineItems, $contextTokenProvider, null);
        $this->assertInstanceOf(Cart::class, $cartWithLineItems);

        $lineItemId = $cartWithLineItems->lineItems[0]->id;
        $productLineItemUpdate = new ProductLineItem($lineItemId, $productId, 1);
        $cartWithDeletedLineItems = $cartClient->deleteProductFromCartByProductId(
            new LineItemCollection($productLineItemUpdate),
            $contextTokenProvider,
            null
        );

        /** @var array<string, mixed> $cartData */
        $cartData = $serializer->normalize($cartWithDeletedLineItems);
        $this->assertArraySubset($expectedCartData, $cartData);
    }

    /**
     * @param array<string, mixed> $expectedCartData
     */
    #[DataProvider('fetchOrCreateCartWithAnonymousUserProvider')]
    public function testFetchOrCreateCartWithAnonymousUser(
        CartClient $cartClient,
        ?ContextTokenProvider $contextTokenProvider,
        Serializer $serializer,
        array $expectedCartData
    ): void {
        $cart = $cartClient->fetchOrCreateCart($contextTokenProvider, null);
        $this->assertInstanceOf(Cart::class, $cart);

        /** @var array<string, mixed> $cartData */
        $cartData = $serializer->normalize($cart);
        $this->assertArraySubset($expectedCartData, $cartData);

        $contextTokenProvider?->resetContextToken();
        $newCart = $cartClient->fetchOrCreateCart($contextTokenProvider, null);
        $this->assertNotSame($cart->token, $newCart->token);
    }

    #[DataProvider('fetchOrCreateCartWithAuthenticatedUserProvider')]
    public function testFetchOrCreateWithAuthenticatedUser(CartClient $cartClient, ContextTokenProvider $contextTokenProvider): void
    {
        $cart = $cartClient->fetchOrCreateCart($contextTokenProvider, null);
        $this->assertInstanceOf(Cart::class, $cart);
    }

    /**
     * @param array<string, mixed> $expectedCartData
     */
    #[DataProvider('updateLineItemsInCartProvider')]
    public function testUpdateLineItemsInCart(
        CartClient $cartClient,
        ?ContextTokenProvider $contextTokenProvider,
        string $productId,
        Serializer $serializer,
        array $expectedCartData
    ): void {
        $cartClient->fetchOrCreateCart($contextTokenProvider, null);
        $lineItems = new LineItemCollection(new ProductLineItem(null, $productId, 1));
        $cartWithLineItems = $cartClient->addLineItemsToCart($lineItems, $contextTokenProvider, null);
        $this->assertInstanceOf(Cart::class, $cartWithLineItems);

        $lineItemId = $cartWithLineItems->lineItems[0]->id;
        $productLineItemUpdate = new ProductLineItem($lineItemId, $productId, 2);
        $cartWithUpdatedLineItems = $cartClient->updateLineItemsInCart(
            new LineItemCollection($productLineItemUpdate),
            $contextTokenProvider,
            null
        );

        /** @var array<string, mixed> $cartData */
        $cartData = $serializer->normalize($cartWithUpdatedLineItems);
        $this->assertArraySubset($expectedCartData, $cartData);
    }

    public static function updateLineItemsInCartProvider(): \Generator
    {
        $cartClient = CreateCartClientHelper::createCartClient($_ENV['SHOPWARE_URL'], $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']);
        $contextTokenProvider = CreateContextTokenProviderHelper::createContextTokenProviderWithAnonymousUser(
            $_ENV['SHOPWARE_URL'],
            $_ENV['SHOPWARE_STORE_ACCESS_TOKEN']
        );
        $serializer = CreateSerializerHelper::createSerializer();

        $lineItemData = [
            'lineItems' => [CreateProductLineItemDataHelper::createProductLineItemData($_ENV['SHOPWARE_STORE_PRODUCT_ID_FOR_TEST'], 2)],
        ];
        yield 'update product line item from quantity 1 to quantity 2' => [
            $cartClient,
            $contextTokenProvider,
            $_ENV['SHOPWARE_STORE_PRODUCT_ID_FOR_TEST'],
            $serializer,
            $lineItemData,
        ];
    }
}
