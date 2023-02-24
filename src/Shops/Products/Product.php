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
        return $this->valueForProperty('title');
    }

    public function description(): string
    {
        return $this->valueForProperty('description');
    }

    public function tags(): array
    {
        return $this->valueForProperty('tags');
    }

    public function options(): array
    {
        return $this->object()->options;
    }

    public function variants(): Variants
    {
        return Variants::fromArray(
            $this->client(),
            $this->valueForProperty('variants')
        );
    }

    public function images(): Images
    {
        return Images::fromArray(
            $this->client(),
            $this->valueForProperty('images')
        );
    }

    public function createdAt(bool $returnDate = false): string|DateTime
    {
        $date = $this->valueForProperty('created_at');
        if ($returnDate === false) {
            return $date;
        }
        return DateTime::createFromFormat(self::TIMESTAMP_FORMAT, $date);
    }

    public function updatedAt(bool $returnDate = false): string|DateTime
    {
        $date = $this->valueForProperty('updated_at');
        if ($returnDate === false) {
            return $date;
        }
        return DateTime::createFromFormat(self::TIMESTAMP_FORMAT, $date);
    }

    public function visible(): bool
    {
        return $this->valueForProperty('visible');
    }

    public function isLocked(): bool
    {
        return $this->valueForProperty('is_locked');
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

    public function printAreas(): array
    {
        return $this->valueForProperty('print_areas');
    }

    public function salesChannelProperties(): array
    {
        return $this->valueForProperty('sales_channel_properties');
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

    public function valueForProperty(string $named): mixed
    {
        $obj = $this->object();
        if (property_exists($obj, $named) === false) {
            $product = $this->client()->getProduct($this->shopId(), $this->id());
            $this->object = $product->object();
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
