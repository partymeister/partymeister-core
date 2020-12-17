<?php

namespace Motor\Backend\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Partymeister\Core\Models\Visitor;

class VisitorFactory extends Factory {
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Visitor::class;

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
