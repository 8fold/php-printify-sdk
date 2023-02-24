<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops;

use Eightfold\Printify\Contracts\Collection;

use StdClass;

use Psr\Http\Message\ResponseInterface;

use Eightfold\Printify\Client;

use Eightfold\Printify\Implementations\Collection as CollectionImp;

class Shops implements Collection
{
    use CollectionImp;

    public static function fromResponse(
        Client $client,
        ResponseInterface $response
    ): self {
        $json  = $response->getBody()->getContents();
        return self::fromJson($client, $json);
    }

    public static function fromJson(
        Client $client,
        string $json
    ): self {
        $array = json_decode($json);
        return self::fromArray($client, $array);
    }

    public static function fromArray(Client $client, array $collection): self
    {
        return new self($client, $collection);
    }

    final private function __construct(
        private Client $client,
        private array $collection
    ) {
    }

    public function atIndex(int $index): Shop
    {
        if (is_a($this->collection[$index], StdClass::class)) {
            $this->collection[$index] = Shop::fromObject(
                $this->client(),
                $this->collection[$index]
            );
        }
        return $this->collection[$index];
    }

    public function shop(int $withId): Shop
    {
        foreach ($this as $shop) {
            if ($shop->id() === $withId) {
                return $shop;
            }
        }
        return $this->atIndex(0);
    }

    private function client(): Client
    {
        return $this->client;
    }

    /** Iterator **/
    public function current(): Shop
    {
        return $this->atIndex($this->position);
    }
}
