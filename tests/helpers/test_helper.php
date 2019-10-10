<?php

function create_test_callback($count = 1)
{
    return factory(Partymeister\Core\Models\Callback::class, $count)->create();
}

function create_test_schedule($count = 1)
{
    return factory(Partymeister\Core\Models\Schedule::class, $count)->create();
}

function create_test_event($count = 1)
{
    return factory(Partymeister\Core\Models\Event::class, $count)->create();
}

function create_test_event_type($count = 1)
{
    return factory(Partymeister\Core\Models\EventType::class, $count)->create();
}

function create_test_guest($count = 1)
{
    return factory(Partymeister\Core\Models\Guest::class, $count)->create();
}

function create_test_visitor($count = 1)
{
    return factory(Partymeister\Core\Models\Visitor::class, $count)->create();
}

function create_test_message_group($count = 1)
{
    return factory(Partymeister\Core\Models\MessageGroup::class, $count)->create();
}
