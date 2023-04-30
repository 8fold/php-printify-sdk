<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests\Shops\Products;

use PHPUnit\Framework\TestCase;

use Eightfold\Printify\Shops\Products\Products;

use Eightfold\Printify\Shops\Products\Product;

use Eightfold\Printify\Client;

use Eightfold\Printify\Printify;

class ProductsTest extends TestCase
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
        $json = file_get_contents(
            __DIR__ . '/../../api-responses/get-products-lite-required.json'
        );

        $sut = Products::fromJson($this->nonApiClient(), $json);

        $expected = 1;

        $result = $sut->currentPage();

        $this->assertSame(
            $expected,
            $result
        );

        $expected = 10;

        $result = $sut->perPage();

        $this->assertSame(
            $expected,
            $result
        );

        $product = $sut->atIndex(0);

        $this->assertTrue(
            is_a($product, Product::class)
        );

        $expected = 5432;

        $result = $product->shopId();

        $this->assertSame(
            $expected,
            $result
        );
    }

    /**
     * @test
     */
    public function can_initialize_without_api_call(): void
    {
        $json = file_get_contents(
            __DIR__ . '/../../api-responses/get-products-lite-all.json'
        );

        $sut = Products::fromJson($this->nonApiClient(), $json);

        $expected = 1;

        $result = $sut->currentPage();

        $this->assertSame(
            $expected,
            $result
        );

        $result = $sut->perPage();

        $this->assertSame(
            $expected,
            $result
        );
    }
}
