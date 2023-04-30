<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops\Products;

use Eightfold\Printify\Contracts\Collection;

use StdClass;

use Psr\Http\Message\ResponseInterface;

use Eightfold\Printify\Client;

use Eightfold\Printify\Implementations\Collection as CollectionImp;

class Products implements Collection
{
    use CollectionImp;

    /**
     * @var array<StdClass|Product>
     */
    private array $collection;

    public static function fromResponse(
        Client $client,
        ResponseInterface $response
    ): self {
        $json = $response->getBody()->getContents();
        return self::fromJson($client, $json);
    }

    public static function fromJson(Client $client, string $json): self
    {
        $object = json_decode($json);
        if (
            is_object($object) === false or
            is_a($object, StdClass::class) === false
        ) {
            $object = new StdClass();
        }
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
        $this->collection = $object->data;
    }

    /** Printify properties **/
    public function currentPage(): int
    {
        return intval($this->objectValueOrDefault('current_page', 1));
    }

    public function perPage(): int
    {
        return intval($this->objectValueOrDefault('per_page', 10));
    }
    /** End Printify properties **/

    public function atIndex(int $index): Product
    {
        if (is_a($this->collection[$index], StdClass::class)) {
            $this->collection[$index] = Product::fromObject(
                $this->client(),
                $this->collection[$index]
            );
        }
        return $this->collection[$index];
    }

    private function objectValueOrDefault(
        string $property,
        string|int|null $default
    ): string|int|null {
        $obj = $this->object();
        if (property_exists($obj, $property)) {
            return $obj->{$property};
        }
        return $default;
    }

    private function client(): Client
    {
        return $this->client;
    }

    private function object(): StdClass
    {
        return $this->object;
    }

    /** Iterator **/
    public function current(): Product
    {
        return $this->atIndex($this->position);
    }
}
