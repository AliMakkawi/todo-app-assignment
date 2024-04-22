<?php

declare(strict_types=1);

namespace App\Todos\Infrastructure\Repositories;

use App\Todos\Domain\Enums\Status;
use App\Todos\Domain\Models\Todo;
use App\Todos\Domain\Repositories\TodoRepository;
use Illuminate\Support\Collection;
final class EloquentTodoRepository implements TodoRepository
{
    public function getAllTodos(): Collection
    {
        return Todo::all()->reverse();
    }

    public function addTodo(string $task): bool
    {
        $todo = new Todo();
        $todo->task = $task;
        $todo->status = Status::PENDING;

        return $todo->save();
    }
}
