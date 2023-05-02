<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests;

use Eightfold\Printify\Tests\TestCase;

use Eightfold\Printify\Endpoints;

use Eightfold\Printify\Shops\Shop;

class EndpointsTest extends TestCase
{
    /**
     * @test
     */
    public function get_products_is_expected_endpoint(): void
    {
        $expected = '/shops/12345/products.json?page=1&limit=20';

        $result = Endpoints::getProducts(12345, limit: 20);

        $this->assertSame(
            $expected,
            $result
        );

        $expected = '/shops/12345/products.json?page=2&limit=20';

        $result = Endpoints::getProducts(12345, 2, 20);

        $this->assertSame(
            $expected,
            $result
        );

        $expected = '/shops/12345/products.json';

        $result = Endpoints::getProducts(12345);

        $this->assertSame(
            $expected,
            $result
        );

        $client = parent::nonApiClient();

        $shop = Shop::withId($client, 12345);

        $result = Endpoints::getProducts($shop);

        $this->assertSame(
            $expected,
            $result
        );
    }
}
