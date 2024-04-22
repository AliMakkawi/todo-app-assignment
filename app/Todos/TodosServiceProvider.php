<?php

declare(strict_types=1);

namespace App\Todos;

use App\Todos\Domain\Repositories\TodoRepository;
use App\Todos\Infrastructure\Repositories\EloquentTodoRepository;
use Illuminate\Support\ServiceProvider;

final class TodosServiceProvider extends ServiceProvider
{
    public array $bindings = [
        TodoRepository::class => EloquentTodoRepository::class,
    ];
}
