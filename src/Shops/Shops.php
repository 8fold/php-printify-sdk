<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops;

use StdClass;
use Traversable;
use Iterator;

use Psr\Http\Message\ResponseInterface;

use Eightfold\Printify\Printify;
use Eightfold\Printify\Shops\Shop;

// use Eightfold\Printify\Implementations\DecodesJson;

class Shops implements Traversable, Iterator
{
    private static ResponseInterface $printifyResponse;

    private static StdClass $printifyObject;

    private array $shops;

    private $position = 0;

    public static function init(): self
    {
        return new self();
    }

    public static function get(): self
    {
        $response = Printify::get(self::endpoint());

        self::$printifyResponse = $response;

        $json = self::$printifyResponse->getBody()->getContents();

        $decodedJson = json_decode($json);

        self::$printifyObject = new StdClass();
        if ($decodedJson === false) {
            self::$printifyObject->data = [];

        } else {
            self::$printifyObject->data = $decodedJson;

        }
        return new self();
    }

    public static function endpoint(): string
    {
        return '/shops.json';
    }

    public function shopWithId(int $id): Shop|false
    {
        foreach ($this as $shop) {
            if ($shop->id() === $id) {
                return $shop;
            }
        }
        return false;
    }

    private function printifyObject(): StdClass
    {
        if (isset(self::$printifyObject) === false) {
            self::get();
        }
        return self::$printifyObject;
    }

    private function shops(): array
    {
        if (isset($this->shops) === false) {
            $this->shops = $this->printifyObject()->data;
        }
        return $this->shops;
    }

    /*********** Iterator ***********/
    public function current(): Shop
    {
        $a = $this->shops();

        $article = $a[$this->position];

        if (is_a($a[$this->position], Shop::class) === false) {
            $a[$this->position] = Shop::init($a[$this->position]);
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
        $a = $this->shops();

        return isset($a[$this->position]);
    }
}
