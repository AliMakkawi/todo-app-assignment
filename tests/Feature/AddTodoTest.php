<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\TodoList;
use App\Todos\Domain\Enums\Status;
use App\Todos\Domain\Models\Todo;
use Livewire\Livewire;
use Tests\TestCase;

class AddTodoTest extends TestCase
{
    public function testCanAddATodo(): void
    {
        Livewire::test(TodoList::class)
            ->set('task', 'New Task')
            ->call('addTodo')
            ->assertSessionHas('_flash.new.0', 'success');

        $this->assertDatabaseHas('todos', [
            'task' => 'New Task',
            'status' => Status::PENDING,
        ]);
    }

    public function testCannotAddTodoIfLimitIsReached(): void
    {
        Todo::factory()->count(50)->create();

        Livewire::test(TodoList::class)
            ->set('task', 'New Task')
            ->call('addTodo')
            ->assertSessionHas('_flash.new.0', 'error');

        $this->assertDatabaseCount('todos', 50);
    }

    public function testCannotAddTodoIfTaskIsEmpty(): void
    {
        Livewire::test(TodoList::class)
            ->set('task', '')
            ->call('addTodo')
            ->assertSessionHas('_flash.new.0', 'error');

        $this->assertDatabaseCount('todos', 0);
    }

    public function testCannotAddTodoIfTaskHasMoreThan100Characters(): void
    {
        Livewire::test(TodoList::class)
            ->set('task', str('A')->repeat(101), )
            ->call('addTodo')
            ->assertSessionHas('_flash.new.0', 'error');

        $this->assertDatabaseCount('todos', 0);
    }
}
