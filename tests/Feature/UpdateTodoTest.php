<?php

namespace Tests\Feature;

use App\Livewire\TodoList;
use App\Todos\Domain\Enums\Status;
use App\Todos\Domain\Models\Todo;
use Livewire\Livewire;
use Tests\TestCase;

class UpdateTodoTest extends TestCase
{
    public function testCanUpdateTodoTask(): void
    {
        $todo = Todo::factory()->task('Old Task')->create();

        Livewire::test(TodoList::class)
            ->call('updateTodoTask', $todo, 'Updated Task')
            ->assertSessionHas('_flash.new.0', 'success');

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'task' => 'Updated Task'
        ]);
    }

    public function testCanUpdateTodoStatus(): void
    {
        $todo = Todo::factory()->status(Status::PENDING)->create();

        Livewire::test(TodoList::class)
            ->call('updateTodoStatus', $todo, true)
            ->assertSessionHas('_flash.new.0', 'success');

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'status' => Status::DONE,
        ]);
    }

    public function testCannotUpdateTodoIfTaskIsEmpty(): void
    {
        $todo = Todo::factory()->task('Old Task')->create();

        Livewire::test(TodoList::class)
            ->call('updateTodoTask', $todo, '')
            ->assertSessionHas('_flash.new.0', 'error');

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'task' => 'Old Task'
        ]);
    }

    public function testCannotUpdateTodoIfTaskHasMoreThan100Characters(): void
    {
        $todo = Todo::factory()->task('Old Task')->create();

        Livewire::test(TodoList::class)
            ->call('updateTodoTask', $todo, str('A')->repeat(101))
            ->assertSessionHas('_flash.new.0', 'error');

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'task' => 'Old Task'
        ]);
    }
}
