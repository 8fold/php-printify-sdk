<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops\Products\Product;

use StdClass;
use Traversable;
use Iterator;

class Options implements Traversable, Iterator
{
    private static StdClass $printifyObject;

    private array $options;

    public static function init(array $options): self
    {
        self::$printifyObject = new StdClass();
        self::$printifyObject->data = $options;
        return new self();
    }

    private function printifyObject(): StdClass
    {
        return self::$printifyObject;
    }

    public function total(): int
    {
        return count($this->options());
    }

    private function options(): array
    {
        if (isset($this->options) === false or
            count($this->options) === 0
        ) {
            if (property_exists($this->printifyObject(), 'data') === false) {
                return [];
            }

            $array = $this->printifyObject()->data;

            $this->options = $array;
        }
        return $this->options;
    }

    /*********** Iterator ***********/
    public function current(): Option
    {
        $a = $this->options();

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
        $a = $this->options();

        return isset($a[$this->position]);
    }
}
