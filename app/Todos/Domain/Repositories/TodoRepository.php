<?php

declare(strict_types=1);

namespace App\Todos\Domain\Repositories;
use Illuminate\Support\Collection;

interface TodoRepository
{
    public function getAllTodos(): Collection;
}
