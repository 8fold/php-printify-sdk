<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops\Products\Variants;

use StdClass;

use Eightfold\Printify\Client;

use Eightfold\Printify\Shops\Products\Product;
use Eightfold\Printify\Shops\Products\Images\Image;
use Eightfold\Printify\Shops\Products\Images\ImageError;

class Variant
{
    public static function fromObject(StdClass $object): self
    {
        return new self($object);
    }

    final private function __construct(private StdClass $object)
    {
    }

    /** Printify properties **/
    public function id(): int
    {
        return $this->object()->id;
    }

    public function sku(): string
    {
        return $this->object()->sku;
    }

    public function cost(): int
    {
        return $this->object()->cost;
    }

    public function price(): int
    {
        return $this->object()->price;
    }

    public function title(): string
    {
        return $this->object()->title;
    }

    public function grams(): int
    {
        return $this->object()->grams;
    }

    public function isEnabled(): bool
    {
        return $this->object()->is_enabled;
    }

    public function isDefault(): bool
    {
        return $this->object()->is_default;
    }

    public function isAvailable(): bool
    {
        return $this->object()->is_available;
    }

    /**
     * @return StdClass[]
     */
    public function options(): array
    {
        return $this->object()->options;
    }

    public function quantity(): int
    {
        return $this->object()->quantity;
    }
    /** End Printify properties **/

    public function isDisabled(): bool
    {
        return ! $this->isEnabled();
    }

    public function isUnavailable(): bool
    {
        return ! $this->isAvailable();
    }

    public function defaultImage(Product $product): Image|false
    {
        return $product->images()->defaultForVariant($this->id());
    }

    /**
     * @return Image[]
     */
    public function images(Product $product): array
    {
        return $product->images()->imagesForVariant($this->id());
    }

    private function object(): StdClass
    {
        return $this->object;
    }
}
