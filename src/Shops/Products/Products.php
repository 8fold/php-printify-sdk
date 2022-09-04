<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops\Products;

use StdClass;
use Traversable;
use Iterator;

use Psr\Http\Message\ResponseInterface;

use Eightfold\Printify\Printify;

use Eightfold\Printify\Shops\Shop;

use Eightfold\Printify\Shops\Products\Product;

class Products implements Traversable, Iterator
{
    private static Shop $shop;

    private static int $shopId;

    private static ResponseInterface $printifyResponse;

    private static StdClass $printifyObject;

    private array $products;

    private $position = 0;

    public static function init(Shop $shop): self
    {
        self::$shop   = $shop;
        self::$shopId = $shop->id();

        return self::get(self::$shopId);
    }

    public static function get(int $shopId): self
    {
        self::$shopId = $shopId;

        self::$printifyResponse = Printify::get(self::endpoint());

        $json = self::$printifyResponse->getBody()->getContents();

        $decodedJson = json_decode($json);

        if ($decodedJson === false) {
            self::$printifyObject = new StdClass();

        } else {
            self::$printifyObject = $decodedJson;

        }
        return new self();
    }

    public static function endpoint(): string
    {
        return '/shops/' . self::$shopId . '/products.json';
    }

    final private function __construct()
    {
    }

    private function printifyObject(): StdClass
    {
        return self::$printifyObject;
    }

    private function products(): array
    {
        if (isset($this->products) === false or
            count($this->products) === 0
        ) {
            if (property_exists($this->printifyObject(), 'data') === false) {
                return [];
            }

            $array = $this->printifyObject()->data;

            $this->products = $array;
        }
        return $this->products;
    }

    /** Printify object members **/
    public function currentPage(): int
    {
        return $this->propertyNamed('current_page');
    }

    public function data(): array
    {
        return $this->propertyNamed('data');
    }

    public function firstPageUrl(): string
    {
        return $this->propertyNamed('first_page_url');
    }

    public function from(): int
    {
        return $this->propertyNamed('from');
    }

    public function lastPage(): int
    {
        return $this->propertyNamed('last_page');
    }

    public function lastPageUrl(): int
    {
        return $this->propertyNamed('last_page_url');
    }

    public function nextPageUrl(): int
    {
        return $this->propertyNamed('next_page_url');
    }

    public function path(): string
    {
        return $this->propertyNamed('path');
    }

    public function perPage(): string
    {
        return $this->propertyNamed('per_page');
    }

    public function previousPageUrl(): string
    {
        return $this->propertyNamed('prev_page_url');
    }

    public function to(): int
    {
        return $this->propertyNamed('to');
    }

    public function total(): int
    {
        return $this->propertyNamed('total');
    }

    private function propertyNamed(string $propertyName): int|string
    {
        return $this->printifyObject()->$propertyName;
    }

    /*********** Iterator ***********/
    public function current(): Product
    {
        $a = $this->products();

        $article = $a[$this->position];

        if (is_a($a[$this->position], Product::class) === false) {
            $a[$this->position] = Product::init(
                $a[$this->position],
                self::$shopId
            );
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
        $a = $this->products();

        return isset($a[$this->position]);
    }
}
