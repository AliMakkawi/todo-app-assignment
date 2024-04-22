<?php

declare(strict_types=1);

namespace App\Todos\Domain\Repositories;

use App\Todos\Domain\Models\Todo;
use Illuminate\Support\Collection;

interface TodoRepository
{
    public function getAllTodos(): Collection;

    public function addTodo(string $task): bool;

    public function updateTodoTask(Todo $todo, string $newTask): bool;

    public function updateTodoStatus(Todo $todo, bool $checked): bool;

    public function deleteTodo(Todo $todo): bool;
}
