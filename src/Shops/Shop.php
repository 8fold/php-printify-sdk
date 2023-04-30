<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops;

use Eightfold\Printify\Contracts\SupportsLazyLoading;

use StdClass;

use Eightfold\Printify\Client;

class Shop implements SupportsLazyLoading
{
    public static function withId(Client $client, int $id): self
    {
        $object = new StdClass();
        $object->id = $id;

        return self::fromObject($client, $object);
    }

    public static function fromObject(Client $client, StdClass $object): self
    {
        return new self($client, $object);
    }

    final private function __construct(
        private Client $client,
        private StdClass $object
    ) {
    }

    public function object(): StdClass
    {
        return $this->object;
    }

    public function id(): int
    {
        return $this->object()->id;
    }

    public function title(): string
    {
        $value = $this->valueForProperty('title');
        if (is_string($value)) {
            return $value;
        }
        return '';
    }

    public function salesChannel(): string
    {
        $value = $this->valueForProperty('sales_channel');
        if (is_string($value)) {
            return $value;
        }
        return '';
    }

    public function valueForProperty(string $named): mixed
    {
        $obj = $this->object();
        if (property_exists($obj, $named) === false) {
            $shop = $this->client()->getShop($this->id());
            if (is_bool($shop) === false and is_a($shop, Shop::class)) {
                $this->object = $shop->object();

            }
        }
        return $this->object->{$named};
    }

    private function client(): Client
    {
        return $this->client;
    }
}
