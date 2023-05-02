<?php
declare(strict_types=1);

namespace Eightfold\Printify\EventHandling;

enum EventError
{
    case InvalidJson;
    case UnsupportedResourceType;
}
