<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests\Shops;

use Eightfold\Printify\Tests\TestCase;

use Eightfold\Printify\Shops\Shops;
use Eightfold\Printify\Shops\Shop;

use Eightfold\Printify\Printify;

class ShopsTest extends TestCase
{
    /**
     * @test
     */
//     public function can_get_shop_by_title():void
//     {
//         $shop = $this->printify->getShops()->shopWithTitle($this->testShopTitle);
//
//         $this->assertNotFalse($shop);
//
//         $this->assertTrue(
//             is_a($shop, Shop::class)
//         );
//     }

    /**
     * @test
     */
//     public function can_get_shop_by_id():void
//     {
//         $shop = $this->printify->getShops()->shopWithId($this->testShopId);
//
//         $this->assertNotFalse($shop);
//
//         $this->assertTrue(
//             is_a($shop, Shop::class)
//         );
//     }

    /**
     * @test
     */
    public function valid_key():void
    {
        $shops = $this->printify->getShops();

        $this->assertTrue(
            is_a($shops, Shops::class)
        );
    }
}
