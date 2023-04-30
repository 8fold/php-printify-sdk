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
    public function can_return_shop_without_api_call(): void
    {
        $shop = $this->nonApiClient()->shop(withId: 12345);

        $this->assertTrue(
            is_a($shop, Shop::class)
        );
    }
}
