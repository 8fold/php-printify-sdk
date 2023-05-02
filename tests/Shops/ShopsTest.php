<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests\Shops;

use Eightfold\Printify\Tests\TestCase;

use Eightfold\Printify\Shops\Shops;

class ShopsTest extends TestCase
{
    private function sut(): Shops
    {
        $json = file_get_contents(__DIR__ . '/../api-responses/get-shops.json');

        return Shops::fromJson(parent::nonApiClient(), $json);
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
