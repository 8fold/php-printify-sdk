<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Printify\Printify;

class PrintifyTest extends TestCase
{
    /**
     * @test
     */
    public function can_get_configuration_values(): void
    {
        $account = Printify::account(accessToken: 'token');

        $expected = 'https://api.printify.com/v1';

        $result = $account->apiVersion();

        $this->assertSame(
            $expected,
            $result
        );

        $expected = 'token';

        $result = $account->accessToken();

        $this->assertSame(
            $expected,
            $result
        );
    }
}
