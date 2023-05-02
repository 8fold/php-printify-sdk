<?php
declare(strict_types=1);

namespace Eightfold\Printify\EventHandling;

use StdClass;
use DateTime;

use Psr\Http\Message\ServerRequestInterface;

use Eightfold\Printify\EventHandling\EventType;

use Eightfold\Printify\Client;

use Eightfold\Printify\EventHandling\EventError;

use Eightfold\Printify\Shops\Products\Product;

class Event
{
    public const TIMESTAMP_FORMAT = 'Y-m-d H:i:sP';

    public static function fromRequest(
        Client $client,
        ServerRequestInterface $request
    ): self|EventError {
        $json = $request->getBody()->getContents();
        return self::fromJson($client, $json);
    }

    public static function fromJson(Client $client, string $json): self|EventError
    {
        $object = json_decode($json);
        if (
            is_object($object) == false or
            is_a($object, StdClass::class) === false
        ) {
            return EventError::InvalidJson;
        }

        return self::fromObject($client, $object);
    }

    public static function fromObject(Client $client, StdClass $object): self
    {
        return new self($client, $object);
    }

    final private function __construct(
        private readonly Client $client,
        private readonly StdClass $object
    ) {
    }

    private function client(): Client
    {
        return $this->client;
    }

    private function object(): StdClass
    {
        return $this->object;
    }

    public function id(): string
    {
        return $this->object()->id;
    }

    public function type(): EventType
    {
        return match ($this->object()->type) {
            'product:publish:started' => EventType::ProductPublishStarted,
            default => EventType::Unsupported
        };
    }

    public function createdAt(): DateTime|false
    {
        return DateTime::createFromFormat(
            self::TIMESTAMP_FORMAT,
            $this->object()->created_at
        );
    }

    public function resourceRaw(): StdClass
    {
        return $this->object()->resource;
    }

    public function resource(): Product|EventError
    {
        $meta = $this->resourceRaw();
        return match ($meta->type) {
            'product' => Product::withId(
                $this->client(),
                $meta->data->shop_id,
                $meta->id
            ),
            default => EventError::UnsupportedResourceType
        };
    }
}
