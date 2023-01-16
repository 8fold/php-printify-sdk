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
    public function does_follow_singleton_pattern(): void
    {
        $accessToken = 'this_represents_the_printify_access_token';

        $apiBase = 'https://api.url/';

        Printify::createSingleton([
            'accessToken' => $accessToken,
            'apiBase'     => $apiBase
        ]);

        $this->assertSame($accessToken, Printify::accessToken());

        $this->assertSame($apiBase, Printify::apiBase());
    }
    /**
     * @test
     */
    public function class_is_found(): void
    {
        $this->assertTrue(
            class_exists(Printify::class)
        );
    }
}
