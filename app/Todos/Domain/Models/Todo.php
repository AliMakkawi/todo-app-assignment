<?php

declare(strict_types=1);

namespace App\Todos\Domain\Models;

use App\Todos\Domain\Enums\Status;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $casts = [
        'status' => Status::class,
    ];

    public function markAsPending(): bool
    {
        $this->status = Status::PENDING;
        return $this->update();
    }

    public function markAsDone(): bool
    {
        $this->status = Status::DONE;
        return $this->update();
    }
}
