<?php

declare(strict_types=1);

namespace App\Todos\Domain\Enums;

enum Status: string
{
    case PENDING  = 'pending';
    case DONE = 'done';
}
