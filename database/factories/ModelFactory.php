<?php

$factory->define(Partymeister\Core\Models\Callback::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(Partymeister\Core\Models\Schedule::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(Partymeister\Core\Models\ScheduleItem::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(Partymeister\Core\Models\Event::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(Partymeister\Core\Models\EventItem::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(Partymeister\Core\Models\EventType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(Partymeister\Core\Models\Guest::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(Partymeister\Competitions\Models\AccessKey::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(Partymeister\Core\Models\Visitor::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});
