<?php
declare(strict_types=1);

namespace Eightfold\Printify\Shops\Products\Images;

enum ImageError
{
    case NoDefaultForVariant;
    case FilenameNotFound;
    case UnexpectedUrl;
}
