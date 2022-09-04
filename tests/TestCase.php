<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests;

use PHPUnit\Framework\TestCase as PhpUnitTestCase;

use Dotenv\Dotenv;

use Eightfold\Printify\Printify;

class TestCase extends PhpUnitTestCase
{
    protected Printify $printify;

    protected int $testShopId;

    protected string $testShopTitle;

    protected string $testProductId;

    public function setUp(): void
    {
        Dotenv::createImmutable(__DIR__ . '/../')->load();

        $token         = $_ENV['PRINTIFY_TOKEN'];
        $testShopId    = (int) $_ENV['TEST_SHOP_ID'];
        $testProductId = $_ENV['TEST_PRODUCT_ID'];
        $testShopTitle = $_ENV['TEST_SHOP_TITLE'];

        $this->printify      = Printify::init($token);
        $this->testShopId    = $testShopId;
        $this->testProductId = $testProductId;
        $this->testShopTitle = $testShopTitle;
    }
}
