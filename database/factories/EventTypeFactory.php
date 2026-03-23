<?php

namespace Partymeister\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Partymeister\Core\Models\EventType;

class EventTypeFactory extends Factory
{
    protected $model = EventType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'web_color' => $this->faker->hexColor(),
            'slide_color' => $this->faker->hexColor(),
        ];
    }
}
