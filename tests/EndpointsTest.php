<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Printify\Endpoints;

use Eightfold\Printify\Client;
use Eightfold\Printify\Printify;

use Eightfold\Printify\Shops\Shop;

class EndpointsTest extends TestCase
{
    /**
     * @test
     */
    public function get_products_is_expected_endpoint(): void
    {
        $expected = '/shops/12345/products.json';

        $result = Endpoints::getProducts(12345);

        $this->assertSame(
            $expected,
            $result
        );

        $client = Client::connect(
            Printify::account('token')
        );

        $shop = Shop::withId($client, 12345);

        $result = Endpoints::getProducts($shop);

        $this->assertSame(
            $expected,
            $result
        );
    }
}
