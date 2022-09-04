<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops\Products\Product;

use StdClass;
use Traversable;
use Iterator;

class Images implements Traversable, Iterator
{
    private static StdClass $printifyObject;

    private array $images;

    public static function init(array $images): self
    {
        self::$printifyObject = new StdClass();
        self::$printifyObject->data = $images;
        return new self();
    }

    private function printifyObject(): StdClass
    {
        return self::$printifyObject;
    }

    public function total(): int
    {
        return count($this->images());
    }

    private function images(): array
    {
        if (isset($this->images) === false or
            count($this->images) === 0
        ) {
            if (property_exists($this->printifyObject(), 'data') === false) {
                return [];
            }

            $array = $this->printifyObject()->data;

            $this->images = $array;
        }
        return $this->images;
    }

    /*********** Iterator ***********/
    public function current(): Option
    {
        $a = $this->images();

        $article = $a[$this->position];

        if (is_a($a[$this->position], Option::class) === false) {
            $a[$this->position] = Option::init($a[$this->position]);
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
        $a = $this->images();

        return isset($a[$this->position]);
    }
}
