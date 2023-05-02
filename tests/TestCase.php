<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

use Eightfold\Printify\Printify;
use Eightfold\Printify\Client;

use Eightfold\Printify\Shops\Products\Product;

class TestCase extends BaseTestCase
{
    protected function printifyAccount(): Printify
    {
        return Printify::account(accessToken: 'token');
    }

    protected function nonApiClient(): Client
    {
        return Client::connect(
            $this->printifyAccount()
        );
    }

    protected function fullProduct(): Product
    {
        $json = file_get_contents(__DIR__ . '/api-responses/get-product.json');

        return Product::fromJson($this->nonApiClient(), $json);
    }
}
