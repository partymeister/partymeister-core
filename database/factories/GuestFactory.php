<?php

namespace Partymeister\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Partymeister\Core\Models\Guest;

class GuestFactory extends Factory
{
    protected $model = Guest::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'handle' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'company' => $this->faker->company(),
            'country' => $this->faker->countryCode(),
            'ticket_code' => strtoupper($this->faker->unique()->bothify('??###')),
            'ticket_type' => $this->faker->randomElement(['VIP', 'Regular']),
            'ticket_order_number' => strtoupper($this->faker->unique()->bothify('ORD###')),
            'has_badge' => false,
            'has_arrived' => false,
            'ticket_code_scanned' => false,
            'comment' => '',
        ];
    }
}
