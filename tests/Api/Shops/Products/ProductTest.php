<?php
declare(strict_types=1);

namespace Eigthfold\Printify\Tests\Api\Shops\Products;

use Eightfold\Printify\Tests\Api\ApiTestCase as TestCase;

use Eightfold\Printify\Shops\Products\Product;

use Eightfold\Printify\Shops\Products\Variants\Variant;
use Eightfold\Printify\Shops\Products\Images\Image;

class ProductTest extends TestCase
{
    /**
     * @test
     */
    public function can_lazy_load_product_details(): void
    {
        $sut = Product::withId(
            $this->apiTestClient(),
            intval($_ENV['PRINTIFY_SHOP_ID']),
            $_ENV['PRODUCT_ID']
        );

        $expected = $_ENV['PRODUCT_ID'];

        $result = $sut->id();

        $this->assertSame(
            $expected,
            $result
        );

        $expected = $_ENV['PRODUCT_TITLE'];

        $result = $sut->title();

        $this->assertSame(
            $expected,
            $result
        );

        $variants = $sut->variants();

        $this->assertTrue(
            $variants->count() > 0
        );

        $variant = $variants->atIndex(0);

        $this->assertTrue(
            is_a($variant, Variant::class)
        );

        $images = $sut->images();

        $this->assertTrue(
            $images->count() > 0
        );

        $image = $images->atIndex(0);

        $this->assertTrue(
            is_a($image, Image::class)
        );
    }
}
