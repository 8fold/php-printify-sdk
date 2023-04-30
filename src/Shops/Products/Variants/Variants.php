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

    /**
     * @param array<StdClass|Variant> $collection
     */
    public static function fromArray(array $collection): self
    {
        return new self($collection);
    }

    /**
     * @param array<StdClass|Variant> $collection
     */
    final private function __construct(private array $collection)
    {
    }

    public function atIndex(int $index): Variant|StdClass
    {
        if (is_a($this->collection[$index], StdClass::class)) {
            $this->collection[$index] = Variant::fromObject(
                $this->collection[$index]
            );
        }
        return $this->collection[$index];
    }

    public function variantWithId(int $variantId): Variant|false
    {
        foreach ($this as $v) {
            if (
                is_a($v, Variant::class) and
                $v->id() === $variantId
            ) {
                return $v;
            }
        }
        return false;
    }

    /** Iterator **/
    public function current(): Variant|StdClass
    {
        return $this->atIndex($this->position);
    }
}
