<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops\Products;

use Eightfold\Printify\Contracts\SupportsLazyLoading;

use StdClass;
use DateTime;

use Psr\Http\Message\ResponseInterface;

use Eightfold\Printify\Client;

use Eightfold\Printify\Shops\Products\Variants\Variants;
use Eightfold\Printify\Shops\Products\Images\Images;

class Product implements SupportsLazyLoading
{
    public const TIMESTAMP_FORMAT = 'Y-m-d H:i:sP';

    public static function withId(
        Client $client,
        int $shopId,
        string $productId
    ): self {
        $object = new StdClass();
        $object->id = $productId;
        $object->shop_id = $shopId;

        return self::fromObject($client, $object);
    }

    public static function fromResponse(
        Client $client,
        ResponseInterface $response
    ): self {
        $json = $response->getBody()->getContents();
        return self::fromJson($client, $json);
    }

    public static function fromJson(Client $client, string $json): self
    {
        $object = json_decode($json);
        if (
            is_object($object) === false or
            is_a($object, StdClass::class) === false
        ) {
            $object = new StdClass();
        }
        return self::fromObject($client, $object);
    }

    public static function fromObject(Client $client, StdClass $object): self
    {
        return new self($client, $object);
    }

    final private function __construct(
        private Client $client,
        private StdClass $object
    ) {
    }

    /** Printify properties **/
    public function id(): string
    {
        return $this->object()->id;
    }

    public function shopId(): int
    {
        return $this->object()->shop_id;
    }

    public function title(): string
    {
        $value = $this->valueForProperty('title');
        if (is_string($value)) {
            return $value;
        }
        return '';
    }

    public function description(): string
    {
        $value = $this->valueForProperty('description');
        if (is_string($value)) {
            return $value;
        }
        return '';
    }

    /**
     * @return string[]
     */
    public function tags(): array
    {
        $value = $this->valueForProperty('tags');
        if (is_array($value)) {
            return $value;
        }
        return [];
    }

    /**
     * @return StdClass[]
     */
    public function options(): array
    {
        $value = $this->object()->options;
        if (is_array($value)) {
            return $value;
        }
        return [];
    }

    public function variants(): Variants
    {
        $value = $this->valueForProperty('variants');
        if (is_array($value)) {
            return Variants::fromArray($value);
        }
        return Variants::fromArray([]);
    }

    public function images(): Images
    {
        $value = $this->valueForProperty('images');
        if (is_array($value)) {
            return Images::fromArray($value);
        }
        return Images::fromArray([]);
    }

    public function createdAt(): DateTime|false
    {
        return DateTime::createFromFormat(
            self::TIMESTAMP_FORMAT,
            $this->createdAtString()
        );
    }

    public function updatedAt(bool $returnDate = false): DateTime|false
    {
        return DateTime::createFromFormat(
            self::TIMESTAMP_FORMAT,
            $this->updatedAtString()
        );
    }

    public function visible(): bool
    {
        $value = $this->valueForProperty('visible');
        if (is_bool($value)) {
            return $value;
        }
        return false;
    }

    public function isLocked(): bool
    {
        $value = $this->valueForProperty('is_locked');
        if (is_bool($value)) {
            return $value;
        }
        return false;
    }

    public function blueprintId(): int
    {
        return intval($this->valueForProperty('blueprint_id'));
    }

    public function userId(): int
    {
        return intval($this->valueForProperty('user_id'));
    }

    public function printProviderId(): int
    {
        return intval($this->valueForProperty('print_provider_id'));
    }

    /**
     * @return StdClass[]
     */
    public function printAreas(): array
    {
        $value = $this->valueForProperty('print_areas');
        if (is_array($value)) {
            return $value;
        }
        return [];
    }

    /**
     * According to the documentation, custom integrations will always be
     * null or an empty array.
     *
     * @return mixed[]
     */
    public function salesChannelProperties(): array
    {
        $value = $this->valueForProperty('sales_channel_properties');
        if (is_array($value)) {
            return $value;
        }
        return [];
    }
    /** End Printify properties **/

    public function isVisible(): bool
    {
        return $this->visible();
    }

    public function isInvisible(): bool
    {
        return ! $this->visible();
    }

    public function isUnlocked(): bool
    {
        return ! $this->isLocked();
    }

    public function createdAtString(): string
    {
        $date = $this->valueForProperty('created_at');
        if (is_string($date)) {
            return $date;
        }
        return date(self::TIMESTAMP_FORMAT);
    }

    public function updatedAtString(): string
    {
        $date = $this->valueForProperty('updated_at');
        if (is_string($date)) {
            return $date;
        }
        return date(self::TIMESTAMP_FORMAT);
    }

    public function valueForProperty(string $named): mixed
    {
        $obj = $this->object();
        if (property_exists($obj, $named) === false) {
            $product = $this->client()->getProduct($this->shopId(), $this->id());
            if (is_a($product, Product::class)) {
                $this->object = $product->object();

            }
        }
        return $this->object()->{$named};
    }

    private function client(): Client
    {
        return $this->client;
    }

    private function object(): StdClass
    {
        return $this->object;
    }
}
