<?php

namespace Database\Factories;

use App\Todos\Domain\Enums\Status;
use App\Todos\Domain\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    protected $model = Todo::class;

    public function definition(): array
    {
        return [
            "task" => $this->faker->sentence(8),
            'status' => $this->faker->randomElement(Status::cases())->value,
        ];
    }

    public function task(string $task): self
    {
        return $this->state([
            'task' => $task,
        ]);
    }

    public function status(Status $status): self
    {
        return $this->state(['status' => $status->value]);
    }

    public function pending(): self
    {
        return $this->status(Status::PENDING);
    }

    public function done(): self
    {
        return $this->status(Status::DONE);
    }
}
