<?php

function create_test_callback($count = 1)
{
    return factory(Partymeister\Core\Models\Callback::class, $count)->create();
}

function create_test_schedule($count = 1)
{
    return factory(Partymeister\Core\Models\Schedule::class, $count)->create();
}

function create_test_schedule_item($count = 1)
{
    return factory(Partymeister\Core\Models\ScheduleItem::class, $count)->create();
}

function create_test_event($count = 1)
{
    return factory(Partymeister\Core\Models\Event::class, $count)->create();
}

function create_test_event_item($count = 1)
{
    return factory(Partymeister\Core\Models\EventItem::class, $count)->create();
}

function create_test_event_type($count = 1)
{
    return factory(Partymeister\Core\Models\EventType::class, $count)->create();
}
