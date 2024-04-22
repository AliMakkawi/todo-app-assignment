<div class="container mx-auto">
    <h1 class="text-center text-3xl font-bold my-4">
        To-Do List
    </h1>
    <div class="w-2/3 mx-auto">
        @if (session('success'))
            <div class="p-4 my-4 text-md text-white rounded-lg bg-green-700" role="alert">
                <span class="font-medium">Success!</span>
                {{ session('success') }}
                <button onclick="return this.parentNode.remove();" class="float-right">
                    <x-heroicon-c-x-mark class="w-6 h-6 fill-white" />
                </button>
            </div>
        @endif
        @if (session('error'))
            <div class="p-4 my-4 text-md text-white rounded-lg bg-red-500" role="alert">
                <span class="font-medium">Error!</span>
                {{ session('error') }}
                <button onclick="return this.parentNode.remove();" class="float-right">
                    <x-heroicon-c-x-mark class="w-6 h-6 fill-white" />
                </button>
            </div>
        @endif
    </div>
    <div class="w-2/3 mx-auto">
        <div class="bg-white shadow-md rounded-lg p-4">
            <div class="mb-4 shadow-lg bg-gray-200 p-4	">
                <form wire:submit="addTodo" class="basis-2/3 flex">
                    <input wire:model="task" type="text" placeholder="Enter task" class="
                    pl-2
                    basis-10/12
                    text-lg
                    rounded-lg
                    border-3
                    border-blue">
                    <button type="submit"  class="
                    basis-2/12
                    bg-blue-500
                    hover:bg-blue-700
                    text-white
                    text-sm
                    font-bold
                    p-2
                    ml-2
                    rounded-full">Add To-do</button>
                </form>
            </div>
            <div class="max-h-[950px] overflow-auto">
                <table class="table-auto relative w-full">
                    <thead class="sticky top-0 bg-gray-200">
                    <tr>
                        <th class="text-left p-2">Status</th>
                        <th class="text-left p-2">Task</th>
                        <th class="text-left p-2">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($todos as $todo)
                        <tr class="border">
                            <td class="p-2">
                                <input
                                    type="checkbox"
                                    wire:change="updateTodoStatus({{$todo}}, $event.target.checked)"
                                    {{ $todo->status === \App\Todos\Domain\Enums\Status::DONE ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                >
                            </td>
                            <td class="p-2">
                                <input
                                    value="{{$todo->task}}"
                                    wire:keydown.enter="updateTodoTask({{$todo}}, $event.target.value)"
                                    type="text"
                                    {{ $todo->status === \App\Todos\Domain\Enums\Status::DONE ? 'disabled' : '' }}
                                    class="{{($todo->status === \App\Todos\Domain\Enums\Status::DONE) ? "line-through w-full" : "w-full"}}"
                                >
                            </td>
                            <td class="p-2">
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-lg font-bold">No to-dos here.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
