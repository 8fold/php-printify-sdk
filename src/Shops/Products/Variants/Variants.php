<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops\Products\Variants;

use Eightfold\Printify\Contracts\Collection;

use StdClass;

use Eightfold\Printify\Client;

use Eightfold\Printify\Shops\Products\Variants\Variant;

use Eightfold\Printify\Implementations\Collection as CollectionImp;

class Variants implements Collection
{
    use CollectionImp;

    public static function fromArray(Client $client, array $collection): self
    {
        return new self($client, $collection);
    }

    final private function __construct(
        private Client $client,
        private array $collection
    ) {
    }

    public function atIndex(int $index): Variant
    {
        if (is_a($this->collection[$index], StdClass::class)) {
            $this->collection[$index] = Variant::fromObject(
                $this->client(),
                $this->collection[$index]
            );
        }
        return $this->collection[$index];
    }

    public function variantWithId(int $variantId): Variant
    {
        foreach ($this as $v) {
            if ($v->id() === $variantId) {
                return $v;
            }
        }
        return $this->atIndex(0);
    }

    private function client(): Client
    {
        return $this->client;
    }

    /** Iterator **/
    public function current(): Variant
    {
        return $this->atIndex($this->position);
    }
}
