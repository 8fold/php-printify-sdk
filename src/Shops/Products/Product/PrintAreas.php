<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops\Products\Product;

use StdClass;
use Traversable;
use Iterator;

class PrintAreas implements Traversable, Iterator
{
    private static StdClass $printifyObject;

    private array $printAreas;

    public static function init(array $printAreas): self
    {
        self::$printifyObject = new StdClass();
        self::$printifyObject->data = $printAreas;
        return new self();
    }

    private function printifyObject(): StdClass
    {
        return self::$printifyObject;
    }

    public function total(): int
    {
        return count($this->printAreas());
    }

    private function printAreas(): array
    {
        if (isset($this->printAreas) === false or
            count($this->printAreas) === 0
        ) {
            if (property_exists($this->printifyObject(), 'data') === false) {
                return [];
            }

            $array = $this->printifyObject()->data;

            $this->printAreas = $array;
        }
        return $this->printAreas;
    }

    /*********** Iterator ***********/
    public function current(): PrintArea
    {
        $a = $this->printAreas();

        $article = $a[$this->position];

        if (is_a($a[$this->position], PrintArea::class) === false) {
            $a[$this->position] = PrintArea::init($a[$this->position]);
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
        $a = $this->printAreas();

        return isset($a[$this->position]);
    }
}
