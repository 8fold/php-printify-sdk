<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops;

use StdClass;

use Eightfold\Printify\Shops\Products\Products;

class Shop
{
    private static StdClass $printifyObject;

    public static function init(StdClass $printifyObject): self
    {
        self::$printifyObject = $printifyObject;

        return new self();
    }

    public static function endpoint(): string
    {
        return '/' . self::$id;
    }

    /**
     * @todo: Disconnect Shop
    public static function disconnect(): void
    {}
     */

    final private function __construct()
    {
    }

    private function printifyOjbect(): StdClass
    {
        return self::$printifyObject;
    }

    public function products(): Products
    {
        return Products::init($this);
    }

    public function hasProducts(): bool
    {
        return $this->products()->total() > 0;
    }

    /** Printify object members **/
    public function id(): int
    {
        return $this->propertyNamed('id');
    }

    public function title(): string
    {
        return $this->propertyNamed('title');
    }

    public function salesChannel(): string
    {
        // Printify official is custom_intergration
        return $this->propertyNamed('sales_channel');
    }

    private function propertyNamed(string $propertyName): int|string|bool
    {
        return $this->printifyOjbect()->$propertyName;
    }
}
