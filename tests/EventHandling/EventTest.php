<?php
declare(strict_types=1);

namespace Eightfold\Printify\Tests\EventHandling;

use Eightfold\Printify\Tests\TestCase;

use Eightfold\Printify\EventHandling\Event;

use Eightfold\Printify\EventHandling\EventType;

use Eightfold\Printify\Shops\Products\Product;

class EventTest extends TestCase
{
    /**
     * @test
     */
    public function can_get_resource(): void
    {
        $json = file_get_contents(
            __DIR__ . '/../api-responses/event-product-publish-started.json'
        );

        $result = Event::fromJson(parent::nonApiClient(), $json)->resource();

        $this->assertTrue(
            is_a($result, Product::class)
        );
    }

    /**
     * @test
     */
    public function has_expected_event_type(): void
    {
        $json = file_get_contents(
            __DIR__ . '/../api-responses/event-product-publish-started.json'
        );

        $expected = EventType::ProductPublishStarted;

        $result = Event::fromJson(parent::nonApiClient(), $json)->type();

        $this->assertSame(
            $expected,
            $result
        );
    }
}
