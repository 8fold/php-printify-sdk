<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests\Api;

use Eightfold\Printify\Tests\Api\ApiTestCase as TestCase;

use Eightfold\Printify\Client;

use Eightfold\Printify\Printify;

use Eightfold\Printify\Shops\Products\Products;

use Dotenv\Dotenv;

class ClientTest extends TestCase
{
    private function sut(): Client
    {
        return $this->apiTestClient();

        Dotenv::createImmutable(__DIR__)->load();

        return Client::connect(
            Printify::account($_ENV['PRINTIFY_TOKEN'])
        );
    }

    /**
     * @test
     */
    public function can_get_products(): void
    {
        $sut = $this->sut();

        $shopId = intval($_ENV['PRINTIFY_SHOP_ID']);

        $products = $sut->getProducts($shopId);

        $this->assertTrue(
            is_a($products, Products::class)
        );

        $this->assertTrue(
            $products->count() > 0
        );
    }

    /**
     * @test
     */
    public function can_get_shop(): void
    {
        $sut = $this->sut();

        $shopId = intval($_ENV['PRINTIFY_SHOP_ID']);

        $expected = $shopId;

        $result = $sut->getShop($shopId)->id();

        $this->assertSame(
            $expected,
            $result
        );
    }

    /**
     * @test
     */
    public function can_get_shops(): void
    {
        $sut = $this->sut();

        $expected = intval($_ENV['SHOP_COUNT']);

        $result = $sut->getShops()->count();

        $this->assertSame(
            $expected,
            $result
        );
    }
}
