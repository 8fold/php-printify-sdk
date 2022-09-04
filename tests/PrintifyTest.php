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
    public function class_is_found():void
    {
        $this->assertTrue(
            class_exists(Printify::class)
        );
    }
}
