<?php

namespace Motor\Backend\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Partymeister\Core\Models\Callback;

class CallbackFactory extends Factory {
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Callback::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'name' => $this->faker->word
		];
	}
}
