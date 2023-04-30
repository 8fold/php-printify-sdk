<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops\Products\Images;

use Eightfold\Printify\Contracts\Collection;

use StdClass;

use Eightfold\Printify\Client;

use Eightfold\Printify\Shops\Products\Variants\Variant;

use Eightfold\Printify\Implementations\Collection as CollectionImp;

use Eightfold\Printify\Shops\Products\Images\ImageError;

class Images implements Collection
{
    use CollectionImp;

    /**
     * @param array<StdClass|Image> $collection
     */
    public static function fromArray(array $collection): self
    {
        return new self($collection);
    }

    /**
     * @param array<StdClass|Image> $collection
     */
    final private function __construct(private array $collection)
    {
    }

    public function atIndex(int $index): Image
    {
        if (is_a($this->collection[$index], StdClass::class)) {
            $this->collection[$index] = Image::fromObject(
                $this->collection[$index]
            );
        }
        return $this->collection[$index];
    }

    /**
     * @return Image[]
     */
    public function imagesForVariant(Variant|int $variant): array
    {
        $variantId = $variant;
        if (is_int($variant) === false) {
            $variantId = $variant->id();
        }

        $images = [];
        foreach ($this as $image) {
            if (in_array($variantId, $image->variantIds())) {
                $images[] = $image;
            }
        }
        return $images;
    }

    public function defaultForVariant(Variant|int $variant): Image|false
    {
        $variantId = $variant;
        if (is_int($variant) === false) {
            $variantId = $variant->id();
        }

        $images = [];
        foreach ($this as $image) {
            if (
                in_array($variantId, $image->variantIds()) and
                $image->isDefault()
            ) {
                return $image;
            }
        }
        return false;
    }

    /** Iterator **/
    public function current(): Image
    {
        return $this->atIndex($this->position);
    }
}
