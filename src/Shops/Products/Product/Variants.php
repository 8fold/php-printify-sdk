<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops\Products\Product;

use StdClass;
use Traversable;
use Iterator;

class Variants implements Traversable, Iterator
{
    private static StdClass $printifyObject;

    private array $variants;

    public static function init(array $variants): self
    {
        self::$printifyObject = new StdClass();
        self::$printifyObject->data = $variants;
        return new self();
    }

    private function printifyObject(): StdClass
    {
        return self::$printifyObject;
    }

    public function total(): int
    {
        return count($this->variants());
    }

    private function variants(): array
    {
        if (isset($this->variants) === false or
            count($this->variants) === 0
        ) {
            if (property_exists($this->printifyObject(), 'data') === false) {
                return [];
            }

            $array = $this->printifyObject()->data;

            $this->variants = $array;
        }
        return $this->variants;
    }

    /*********** Iterator ***********/
    public function current(): Variant
    {
        $a = $this->variants();

        $article = $a[$this->position];

        if (is_a($a[$this->position], Variant::class) === false) {
            $a[$this->position] = Variant::init($a[$this->position]);
        }
        return $a[$this->position];
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        $a = $this->variants();

        return isset($a[$this->position]);
    }
}
