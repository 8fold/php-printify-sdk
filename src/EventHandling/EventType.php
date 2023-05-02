<?php
declare(strict_types=1);

namespace Eightfold\Printify\EventHandling;

enum EventType
{
    case Unsupported;
    case ProductPublishStarted;
}
