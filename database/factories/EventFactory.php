<?php

namespace Partymeister\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Partymeister\Core\Models\Event;
use Partymeister\Core\Models\EventType;
use Partymeister\Core\Models\Schedule;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(3, true),
            'schedule_id' => Schedule::factory(),
            'event_type_id' => EventType::factory(),
            'is_visible' => 1,
            'is_organizer_only' => 0,
            'sort_position' => $this->faker->numberBetween(0, 100),
            'notify_minutes' => 0,
            'link' => '',
        ];
    }
}
