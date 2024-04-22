<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Todos\Domain\Models\Todo;
use App\Todos\Domain\Repositories\TodoRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Component;

class TodoList extends Component
{
    public Collection $todos;

    public string $task = '';

    private TodoRepository $todoRepository;

    public function boot(TodoRepository $todoRepository): void
    {
        $this->todoRepository = $todoRepository;
    }

    public function mount(): void
    {
        $this->getAllTodos();
    }

    private function getAllTodos(): void
    {
        $this->todos = $this->todoRepository->getAllTodos();
    }

    public function addTodo(): void
    {
        try {
            $validatedTask = $this->validate([
                'task' => 'required|string|max:100'
            ]);

            if ($this->todoRepository->countTodos() >= 50) {
                session()->flash('error', 'You cannot have more than 50 to-dos.');
                return;
            }

            $wasAdded = $this->todoRepository->addTodo($validatedTask['task']);

            if ($wasAdded) {
                $this->getAllTodos();
                $this->task = '';
                session()->flash('success', 'To-do successfully added.');
            } else {
                session()->flash('error', 'To-do failed to be added.');
            }
        } catch (ValidationException $exception) {
            $errorMessage = $exception->validator->errors()->first();
            session()->flash('error', $errorMessage);

        }
    }
    public function updateTodoTask(Todo $todo, string $task): void
    {
        $validator = Validator::make(['task' => $task], [
            'task' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->first());
            return;
        }

        if($todo->task === $task) {
            return;
        }

        $wasUpdated = $this->todoRepository->updateTodoTask($todo, $task);

        if($wasUpdated) {
            $this->getAllTodos();
            $this->flashMessage('success', 'To-do task successfully updated.');
            return;
        }
        $this->flashMessage('error', 'To-do task failed to update.');

    }

    public function updateTodoStatus(Todo $todo, bool $checked): void
    {
        $wasUpdated = $this->todoRepository->updateTodoStatus($todo, $checked);

        if($wasUpdated) {
            $this->getAllTodos();
            $this->flashMessage('success', 'To-do status successfully updated.');
            return;
        }
        $this->flashMessage('error', 'To-do status failed to update.');
    }

    public function deleteTodo(Todo $todo): void
    {
        $wasDeleted = $this->todoRepository->deleteTodo($todo);

        if($wasDeleted) {
            $this->getAllTodos();
            $this->flashMessage('success', 'To-do successfully deleted.');
            return;
        }
        $this->flashMessage('error', 'To-do failed to delete.');
    }

    private function flashMessage(string $status, string $message): void
    {
        session()->flash($status, $message);
    }

    public function render(): View
    {
        return view('livewire.todo-list');
    }
}
