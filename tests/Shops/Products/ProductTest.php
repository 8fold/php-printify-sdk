<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests\Shops\Products;

use Eightfold\Printify\Tests\TestCase;

use Eightfold\Printify\Shops\Products\Product;

class ProductTest extends TestCase
{
    private Shop $shop;

    /**
     * @test
     * @group focus
     */
    public function can_get_images(): void
    {
        $images = $this->printify->getProductWithIn(
            $this->testProductId,
            $this->testShopId
        )->images();

        $this->assertSame($images->total(), 3);
    }

    /**
     * @test
     */
    public function can_get_options(): void
    {
        $options = $this->printify->getProductWithIn(
            $this->testProductId,
            $this->testShopId
        )->options();

        $this->assertSame($options->total(), 23);
    }

    /**
     * @test
     */
    public function can_get_variants(): void
    {
        $variants = $this->printify->getProductWithIn(
            $this->testProductId,
            $this->testShopId
        )->variants();

        $this->assertSame($variants->total(), 23);
    }

    /**
     * @test
     */
    public function can_get_using_product_id(): void
    {
        $products = $this->printify->getShopWithId($this->testShopId)
            ->products();

        $first = null;
        foreach ($products as $product) {
            $first = $product;
            break;
        }

        $id = $first->id();
        $shopId = $first->shopId();

        $product = Product::get($id, $shopId);

        $this->assertNotSame($first, $product);

        $this->assertSame($first->id(), $product->id());

        $this->assertSame($first->shopId(), $product->shopId();
    }

    /**
     * @test
     */
    public function class_is_found():void
    {
        $this->assertTrue(
            class_exists(Product::class)
        );
    }
}
