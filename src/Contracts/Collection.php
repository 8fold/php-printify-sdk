<?php
declare(strict_types=1);

namespace Eightfold\Printify\Contracts;

use Countable;
use Iterator;
use Traversable;

interface Collection extends Countable, Iterator, Traversable
{
    public function atIndex(int $index): mixed;
}
