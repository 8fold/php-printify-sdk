<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests\Shops\Products\Images;

use Eightfold\Printify\Tests\Shops\Products\ProductTest;

class ImageTest extends ProductTest
{
    /**
     * @test
     */
    public function can_get_filename(): void
    {
        $expected = 'mug-11oz.jpg';

        $product = $this->fullProduct();

        $variants = $product->variants();

        $variant = $variants->atIndex(0);

        $result = $variant->defaultImage($product)->filename();

        $this->assertSame(
            $expected,
            $result
        );
    }
}
