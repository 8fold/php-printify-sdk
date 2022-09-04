<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops\Products;

use StdClass;

use Psr\Http\Message\ResponseInterface;

use Eightfold\Printify\Printify;

use Eightfold\Printify\Shops\Products\Product\Variants;
use Eightfold\Printify\Shops\Products\Product\Options;
use Eightfold\Printify\Shops\Products\Product\Images;

class Product
{
    public static StdClass $printifyObject;

    public static string $productId;

    public static int $shopId;

    /**
     * @param StdClass $printifyObject Product object from Printify.
     *
     * @return self
     */
    public static function init(StdClass $printifyObject, int $shopId): self
    {
        self::$printifyObject = $printifyObject;
        self::$productId      = $printifyObject->id;
        self::$shopId         = $shopId;

        return new self();
    }

    public static function get(string $productId, int $shopId): self|false
    {
        self::$productId      = $productId;
        self::$shopId         = $shopId;

        $json = Printify::get(self::endpoint())->getBody()->getContents();

        $decodedJson = json_decode($json);
        if ($decodedJson === false) {
            return false;
        }

        return self::init($decodedJson, $shopId);
    }

    public static function endpoint(): string
    {
        return '/shops/' . self::$shopId . '/products/' . self::$productId . '.json';
    }

    final private function __construct()
    {
    }

    private function printifyOjbect(): StdClass
    {
        return self::$printifyObject;
    }

    /** Printify object members **/
    public function id(): string
    {
        return $this->propertyNamed('id');
    }

    public function title(): string
    {
        return $this->propertyNamed('title');
    }

    public function description(): string
    {
        return $this->propertyNamed('description');
    }

    public function tags(): array
    {
        return $this->propertyNamed('tags');
    }

    /**
     * @todo: Use instance of collection object.
     */
    public function options(): Options
    {
        $options = $this->propertyNamed('options');
        return Options::init($options);
    }

    /**
     * @todo: Use instance of collection object.
     */
    public function variants(): Variants
    {
        $variants = $this->propertyNamed('variants');
        return Variants::init($variants);
    }

    /**
     * @todo: Use instance of collection object.
     */
    public function images(): Images
    {
        $images = $this->propertyNamed('images');
        return Images::init($images);
    }

    public function createdAt(): string
    {
        return $this->propertyNamed('created_at');
    }

    public function updatedAt(): string
    {
        return $this->propertyNamed('updated_at');
    }

    public function visible(): bool
    {
        return $this->propertyNamed('visible');
    }

    public function isLocked(): bool
    {
        return $this->propertyNamed('is_locked');
    }

    public function blueprintId(): int
    {
        return $this->propertyNamed('blueprint_id');
    }

    public function userId(): int
    {
        return $this->propertyNamed('user_id');
    }

    public function shopId(): int
    {
        return $this->propertyNamed('shop_id');
    }

    public function printProviderId(): int
    {
        return $this->propertyNamed('print_provider_id');
    }

    /**
     * @todo: Use instance of collection object.
     */
    public function printAreas(): PrintAreas
    {
    }

    private function propertyNamed(string $propertyName): int|string|bool|array
    {
        return $this->printifyOjbect()->$propertyName;
    }
}
