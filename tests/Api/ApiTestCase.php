<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests\Api;

use PHPUnit\Framework\TestCase;

use Eightfold\Printify\Client;

use Eightfold\Printify\Printify;

use Dotenv\Dotenv;

class ApiTestCase extends TestCase
{
    protected function apiTestClient(): Client
    {
        Dotenv::createImmutable(__DIR__)->load();

        return Client::connect(
            Printify::account($_ENV['PRINTIFY_TOKEN'])
        );
    }
}
