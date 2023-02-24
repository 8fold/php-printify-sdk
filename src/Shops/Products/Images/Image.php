<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops\Products\Images;

use StdClass;

use Eightfold\Printify\Client;

class Image
{
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
    public function src(): string
    {
        return $this->object()->src;
    }

    public function variantIds(): array
    {
        return $this->object()->variant_ids;
    }

    public function position(): string
    {
        // TODO: Create enumerated return for each use case.
        return $this->object()->position;
    }
    /** End Printify properties **/

    public function isDefault(): bool
    {
        return $this->object()->is_default;
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
