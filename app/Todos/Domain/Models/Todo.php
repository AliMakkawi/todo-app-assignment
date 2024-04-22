<?php

declare(strict_types=1);

namespace App\Todos\Domain\Models;

use App\Todos\Domain\Enums\Status;
use Database\Factories\TodoFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

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

    protected static function newFactory(): Factory
    {
        return TodoFactory::new();
    }
}
