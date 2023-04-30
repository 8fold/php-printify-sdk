<?php
declare(strict_types=1);

namespace Eightfold\Printify\Contracts;

interface SupportsLazyLoading
{
    public function valueForProperty(string $property): mixed;
}
