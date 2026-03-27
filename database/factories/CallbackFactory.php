<?php

namespace Partymeister\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Partymeister\Core\Models\Callback;

class CallbackFactory extends Factory
{
    protected $model = Callback::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'action' => 'notify',
            'payload' => '{}',
            'title' => $this->faker->sentence(3),
            'body' => $this->faker->sentence(),
            'link' => '',
            'destination' => $this->faker->randomElement(['slack', 'telegram', 'orga']),
            'hash' => Str::random(10),
            'is_timed' => false,
            'has_fired' => false,
        ];
    }
}
