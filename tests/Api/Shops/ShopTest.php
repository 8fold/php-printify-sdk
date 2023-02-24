<?php
declare(strict_types=1);

namespace Eigthfold\Printify\Tests\Api\Shops;

use Eightfold\Printify\Tests\Api\ApiTestCase as TestCase;

use Eightfold\Printify\Shops\Shop;

use Eightfold\Printify\Client;

use Eightfold\Printify\Printify;

class ShopTest extends TestCase
{
    /**
     * @test
     */
    public function can_lazy_load_shop_details(): void
    {
        $sut = Shop::withId(
            $this->apiTestClient(),
            intval($_ENV['PRINTIFY_SHOP_ID'])
        );

        $expected = intval($_ENV['PRINTIFY_SHOP_ID']);

        $result = $sut->id();

        $this->assertSame(
            $expected,
            $result
        );

        $expected = $_ENV['SHOP_TITLE'];

        $result = $sut->title();

        $this->assertSame(
            $expected,
            $result
        );

        $expected = 'custom_integration';

        $result = $sut->salesChannel();

        $this->assertSame(
            $expected,
            $result
        );
    }
}
