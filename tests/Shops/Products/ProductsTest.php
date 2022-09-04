<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests\Shops\Products;

use Eightfold\Printify\Tests\TestCase;

use Eightfold\Printify\Shops\Shop;

use Eightfold\Printify\Shops\Products\Products;

class ProductsTest extends TestCase
{
    private Shop $shop;

    /**
     * @test
     */
    public function can_get_products():void
    {
        $this->assertSame(
            Products::get($this->testShopId)->total(),
            2
        );

        $this->assertSame(
            $this->shop->products()->total(),
            2
        );
    }

    /**
     * @test
     */
    public function has_products():void
    {
        $this->assertTrue(
            $this->shop->hasProducts()
        );
    }

    /**
     * @test
     */
    public function can_get_current_page():void
    {
        $this->assertSame(
            $this->shop->products()->total(),
            2
        );
    }

    /**
     * @test
     */
    public function class_is_found():void
    {
        $this->assertTrue(
            class_exists(Products::class)
        );
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->shop = $this->printify->getShops()
            ->shopWithId($this->testShopId);
    }
}
