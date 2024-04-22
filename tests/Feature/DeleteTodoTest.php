<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\TodoList;
use App\Todos\Domain\Models\Todo;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteTodoTest extends TestCase
{
    public function testCanDeleteATodo(): void
    {
        $todo = Todo::factory()->create();

        Livewire::test(TodoList::class)
            ->call('deleteTodo', $todo)
            ->assertSessionHas('_flash.new.0', 'success');

        $this->assertDatabaseMissing('todos', [
            'id' => $todo->id
        ]);
    }

    public function testCanDeleteAllTodos(): void
    {
        Todo::factory()->count(10)->create();

        Livewire::test(TodoList::class)
            ->call('deleteAllTodos')
            ->assertSessionHas('_flash.new.0', 'success');

        $this->assertDatabaseCount('todos', 0);
    }

    public function testCanDeleteDoneTodos(): void
    {
        Todo::factory()->done()->count(3)->create();
        Todo::factory()->pending()->count(7)->create();

        Livewire::test(TodoList::class)
            ->call('deleteDoneTodos')
            ->assertSessionHas('_flash.new.0', 'success');

        $this->assertDatabaseCount('todos', 7);
    }
}
