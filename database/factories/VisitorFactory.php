<?php

namespace Partymeister\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Partymeister\Core\Models\Visitor;

class VisitorFactory extends Factory
{
    protected $model = Visitor::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->userName(),
            'group' => $this->faker->word(),
            'country_iso_3166_1' => $this->faker->countryCode(),
            'password' => bcrypt('secret'),
            'api_token' => Str::random(60),
            'additional_data' => [],
        ];
    }
}
