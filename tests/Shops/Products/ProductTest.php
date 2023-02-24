<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests\Shops\Products;

use PHPUnit\Framework\TestCase;

use Eightfold\Printify\Shops\Products\Products;

use Eightfold\Printify\Shops\Products\Product;

use Eightfold\Printify\Client;

use Eightfold\Printify\Printify;

use DateTime;

class ProductTest extends TestCase
{
    private function nonApiClient(): Client
    {
        return Client::connect(
            Printify::account('token')
        );
    }

    private function fullProduct(): Product
    {
        $json = file_get_contents(__DIR__ . '/../../api-responses/get-product.json');

        return Product::fromJson($this->nonApiClient(), $json);
    }

    /**
     * @test
     */
    public function can_return_product_without_api_call_using_required_ids(): void
    {
        $sut = Product::withId($this->nonApiClient(), 1234, 'productid');

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
        $product = $this->fullProduct();

        $expected = '2019-07-25 13:40:41+00:00';

        $result = $product->createdAt();

        $this->assertSame(
            $expected,
            $result
        );

        $result = $product->createdAt(returnDate: true)
            ->format($product::TIMESTAMP_FORMAT);

        $this->assertSame(
            $expected,
            $result
        );

        $expected = '2019-07-25 13:40:59+00:00';

        $result = $product->updatedAt();

        $this->assertSame(
            $expected,
            $result
        );

        $result = $product->updatedAt(returnDate: true)
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
        $product = $this->fullProduct();

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
