<?php

declare(strict_types=1);

namespace App\Livewire;
use Livewire\Component;

class TodoList extends Component
{
    public function render(): View
    {
        return view('livewire.todo-list');
    }
}
