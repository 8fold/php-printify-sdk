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

    public static function fromArray(Client $client, array $collection): self
    {
        return new self($client, $collection);
    }

    final private function __construct(
        private Client $client,
        private array $collection
    ) {
    }

    public function atIndex(int $index): Image
    {
        if (is_a($this->collection[$index], StdClass::class)) {
            $this->collection[$index] = Image::fromObject(
                $this->client(),
                $this->collection[$index]
            );
        }
        return $this->collection[$index];
    }

    public function defaultForVariant(Variant|int $variant): Image|ImageError
    {
        $image = $this->imagesForVariant($variant, true);
        if (is_a($image, Image::class)) {
            return $image;
        }
        return ImageError::NoDefaultForVariant;
    }

    public function imagesForVariant(
        Variant|int $variant,
        bool $defaultOnly = false
    ): array|Image {
        $variantId = $variant;
        if (is_int($variant) === false) {
            $variantId = $variant->id();
        }

        $images = [];
        foreach ($this as $image) {
            if (in_array($variantId, $image->variantIds())) {
                if ($defaultOnly and $image->isDefault()) {
                    return $image;
                }
                $images[] = $image;
            }
        }
        return $images;
    }

    private function client(): Client
    {
        return $this->client;
    }

    /** Iterator **/
    public function current(): Image
    {
        return $this->atIndex($this->position);
    }
}
