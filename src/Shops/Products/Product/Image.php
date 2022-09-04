<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops\Products\Product;

use StdClass;

class Image
{
    private static StdClass $printifyObject;

    public static function init(StdClass $printifyObject): self
    {
        self::$printifyObject = $printifyObject;
        return new self();
    }

    private function printifyObject(): StdClass
    {
        return self::$printifyObject;
    }
}
