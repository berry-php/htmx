<?php

declare(strict_types=1);

namespace Berry\Htmx;

use Deprecated;

enum HxTarget: string
{
    case This = 'this';
    #[Deprecated("Pass an explicit selector such as 'closest .card' to hxTarget instead. Will be removed with 0.6.")]
    case ClosestParent = 'closest parent';
    case Next = 'next';
    case Previous = 'previous';
    case Body = 'body';
    case Host = 'host';
}
