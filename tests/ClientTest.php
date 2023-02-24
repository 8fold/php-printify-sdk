<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Printify\Client;

use Eightfold\Printify\Printify;

use Eightfold\Printify\Shops\Shop;
use Eightfold\Printify\Shops\Products\Product;

class ClientTest extends TestCase
{
    private function nonApiClient(): Client
    {
        return Client::connect(
            Printify::account('token')
        );
    }

    /**
     * @test
     */
    public function can_return_products_without_api_call(): void
    {
        $products = $this->nonApiClient()->products(
            12345,
            [
                'A5d39b159e7c48c000728c89',
                'A5d39b159e7c48c000728c89',
                'B5d39b159e7c48c000728c89',
                'C5d39b159e7c48c000728c89'
            ]
        );

        $this->assertTrue(
            $products->count() === 3
        );

        $this->assertTrue(
            is_a($products->atIndex(0), Product::class)
        );

        $this->assertTrue(
            $products->atIndex(1)->shopId() === 12345
        );
    }

    /**
     * @test
     */
    public function can_return_shop_without_api_call(): void
    {
        $shop = $this->nonApiClient()->shop(withId: 12345);

        $this->assertTrue(
            is_a($shop, Shop::class)
        );
    }
}
