<?php

declare(strict_types=1);

namespace App\Todos\Infrastructure\Repositories;

use App\Todos\Domain\Enums\Status;
use App\Todos\Domain\Models\Todo;
use App\Todos\Domain\Repositories\TodoRepository;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function updateTodoTask(Todo $todo, string $newTask): bool
    {
        $todo->task = $newTask;
        return $todo->update();
    }

    public function updateTodoStatus(Todo $todo, bool $checked): bool
    {
        if($checked) {
            return $todo->markAsDone();
        }
        return $todo->markAsPending();
    }

    public function deleteTodo(Todo $todo): bool
    {
        return $todo->delete();
    }

    public function deleteDoneTodos(): bool
    {
        try {
            return DB::transaction(function () {
                $deleted = Todo::where('status', '=', Status::DONE)->delete();
                return $deleted > 0;
            });
        } catch (Exception $e) {
            return $this->handleError($e, 'deleteDoneTodos', get_class($e));
        }
    }

    public function deleteAllTodos(): bool
    {
        try {
            return DB::transaction(function () {
                Todo::query()->delete();
                return true;
            });
        } catch (Exception $e) {
            return $this->handleError($e, 'deleteAllTodos', get_class($e));
        }
    }
    private function handleError(Exception $e, string $context, string $type): bool
    {
        Log::error(
            "Error in $context ($type): " . $e->getMessage(),
            [
                'timestamp' => now()->toDateTimeString(),
            ]
        );
        return false;
    }
}
