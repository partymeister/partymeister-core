<?php

use Partymeister\Core\Models\Callback;
use Partymeister\Core\Models\Event;
use Partymeister\Core\Models\EventType;
use Partymeister\Core\Models\Guest;
use Partymeister\Core\Models\MessageGroup;
use Partymeister\Core\Models\Schedule;
use Partymeister\Core\Models\Visitor;

function create_test_callback($count = 1)
{
    return factory(Callback::class, $count)->create();
}

function create_test_schedule($count = 1)
{
    return factory(Schedule::class, $count)->create();
}

function create_test_event($count = 1)
{
    return factory(Event::class, $count)->create();
}

function create_test_event_type($count = 1)
{
    return factory(EventType::class, $count)->create();
}

function create_test_guest($count = 1)
{
    return factory(Guest::class, $count)->create();
}

function create_test_visitor($count = 1)
{
    return factory(Visitor::class, $count)->create();
}

function create_test_message_group($count = 1)
{
    return factory(MessageGroup::class, $count)->create();
}
