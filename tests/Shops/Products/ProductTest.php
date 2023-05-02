<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests\Shops\Products;

use Eightfold\Printify\Tests\TestCase;

use Eightfold\Printify\Shops\Products\Product;

class ProductTest extends TestCase
{
    /**
     * @test
     */
    public function can_return_product_without_api_call_using_required_ids(): void
    {
        $sut = Product::withId(parent::nonApiClient(), 1234, 'productid');

        $expected = 1234;

        $result = $sut->shopId();

        $this->assertSame(
            $expected,
            $result
        );

        $expected = 'productid';

        $result = $sut->id();

        $this->assertSame(
            $expected,
            $result
        );
    }

    /**
     * @test
     */
    public function can_get_dates(): void
    {
        $product = parent::fullProduct();

        $expected = '2019-07-25 13:40:41+00:00';

        $result = $product->createdAtString();

        $this->assertSame(
            $expected,
            $result
        );

        $result = $product->createdAt()
            ->format($product::TIMESTAMP_FORMAT);

        $this->assertSame(
            $expected,
            $result
        );

        $expected = '2019-07-25 13:40:59+00:00';

        $result = $product->updatedAtString();

        $this->assertSame(
            $expected,
            $result
        );

        $result = $product->updatedAt()
            ->format($product::TIMESTAMP_FORMAT);

        $this->assertSame(
            $expected,
            $result
        );
    }

    /**
     * @test
     */
    public function can_get_images_for_variant(): void
    {
        $product = parent::fullProduct();

        $variants = $product->variants();

        $variant = $variants->atIndex(0);

        $result = $variant->defaultImage($product)->isDefault();

        $this->assertTrue(
            $result
        );

        $result = $variant->images($product);

        $this->assertTrue(
            count($result) === 2
        );

        $images = $product->images();

        $result = $images->defaultForVariant($variant)->isDefault();

        $this->assertTrue(
            $result
        );

        $result = $images->imagesForVariant($variant);

        $this->assertTrue(
            count($result) === 2
        );
    }
}
