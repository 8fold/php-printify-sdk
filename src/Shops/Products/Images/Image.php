<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops\Products\Images;

use StdClass;

use Eightfold\Printify\Client;

use Eightfold\Printify\Shops\Products\Images\ImageError;

class Image
{
    public static function fromObject(StdClass $object): self
    {
        return new self($object);
    }

    final private function __construct(private readonly StdClass $object)
    {
    }

    /** Printify properties **/
    public function src(): string
    {
        return $this->object()->src;
    }

    /**
     * @return int[]
     */
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

    public function filename(): string|ImageError
    {
        $path = $this->filePath();
        if (is_string($path)) {
            $parts = explode('/', $path);
            return array_pop($parts);
        }
        return $path;
    }

    public function filePath(bool $includeHost = true): string|ImageError
    {
        $src   = $this->src();
        $parts = parse_url($src);
        if (
            is_array($parts) === false or
            array_key_exists('path', $parts) === false or
            array_key_exists('scheme', $parts) === false or
            array_key_exists('host', $parts) === false
        ) {
            return ImageError::UnexpectedUrl;
        }

        if ($includeHost === false) {
            return $parts['path'];
        }
        return $parts['scheme'] . '://' . $parts['host'] . $parts['path'];
    }

    private function object(): StdClass
    {
        return $this->object;
    }
}
