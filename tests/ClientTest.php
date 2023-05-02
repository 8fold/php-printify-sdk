<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests;

use Eightfold\Printify\Tests\TestCase;

use Eightfold\Printify\Shops\Shop;

class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function can_return_shop_without_api_call(): void
    {
        $shop = parent::nonApiClient()->shop(withId: 12345);

        $this->assertTrue(
            is_a($shop, Shop::class)
        );
    }
}
