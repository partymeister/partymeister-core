<?php

namespace Partymeister\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Partymeister\Core\Models\MessageGroup;

class MessageGroupFactory extends Factory
{
    protected $model = MessageGroup::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'uuid' => $this->faker->unique()->uuid(),
        ];
    }
}
