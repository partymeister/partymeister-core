<?php

namespace Partymeister\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Partymeister\Core\Models\EventType;

class EventTypesTableSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Competition', 'web_color' => 'rgba(99, 168, 72, 1)', 'slide_color' => 'rgba(60, 105, 44, 1)'],
            ['name' => 'Deadline', 'web_color' => 'rgba(229, 85, 74, 1)', 'slide_color' => 'rgba(229, 85, 74, 1)'],
            ['name' => 'Event', 'web_color' => 'rgba(250, 208, 40, 1)', 'slide_color' => 'rgba(250, 208, 40, 1)'],
            ['name' => 'Demoshow', 'web_color' => 'rgba(136, 187, 255, 1)', 'slide_color' => 'rgba(136, 187, 255, 1)'],
            ['name' => 'Live Act', 'web_color' => 'rgba(240, 214, 110, 1)', 'slide_color' => 'rgba(240, 214, 110, 1)'],
            ['name' => 'Seminar', 'web_color' => 'rgba(240, 214, 110, 1)', 'slide_color' => 'rgba(240, 214, 110, 1)'],
            ['name' => 'Concert', 'web_color' => 'rgba(240, 214, 110, 1)', 'slide_color' => 'rgba(240, 214, 110, 1)'],
            ['name' => 'Organizer Only', 'web_color' => 'rgba(255, 255, 255, 1)', 'slide_color' => 'rgba(255, 255, 255, 1)'],
            ['name' => 'Shuttles', 'web_color' => 'rgba(54, 108, 255, 1)', 'slide_color' => 'rgba(54, 108, 255, 1)'],
            ['name' => '2nd Stage', 'web_color' => 'rgba(240, 214, 110, 1)', 'slide_color' => 'rgba(240, 214, 110, 1)'],
        ];

        foreach ($types as $type) {
            EventType::create($type);
        }
    }
}
