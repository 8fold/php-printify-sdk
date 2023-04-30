<?php
declare(strict_types=1);

namespace Eigthfold\Printify\Tests\Shops;

use PHPUnit\Framework\TestCase;

use Eightfold\Printify\Shops\Shops;

use Eightfold\Printify\Client;

use Eightfold\Printify\Printify;

class ShopsTest extends TestCase
{
    private function sut(): Shops
    {
        $json = file_get_contents(__DIR__ . '/../api-responses/get-shops.json');

        $client = Client::connect(
            Printify::account('token')
        );

        return Shops::fromJson($client, $json);
    }

    /**
     * @test
     */
    public function can_get_first_shop(): void
    {
        $sut = $this->sut();

        $first = $sut->atIndex(0);

        $expected = 5432;

        $result = $first->id();

        $this->assertSame(
            $expected,
            $result
        );

        $expected = 'My new store';

        $result = $first->title();

        $this->assertSame(
            $expected,
            $result
        );

        $expected = 'My Sales Channel';

        $result = $first->salesChannel();

        $this->assertSame(
            $expected,
            $result
        );
    }

    /**
     * @test
     */
    public function has_correct_count(): void
    {
        $expected = 2;

        $result = $this->sut()->count();

        $this->assertSame(
            $expected,
            $result
        );
    }
}
