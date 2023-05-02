<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests;

use Eightfold\Printify\Tests\TestCase;

use Eightfold\Printify\Printify;

class PrintifyTest extends TestCase
{
    /**
     * @test
     */
    public function can_get_configuration_values(): void
    {
        $account = parent::printifyAccount();

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
