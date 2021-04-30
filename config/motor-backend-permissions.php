<?php

return [
    'partymeister'   => [
        'name'   => 'partymeister-core::backend/partymeister.partymeister',
        'values' => [
            'read',
        ],
    ],
    'callbacks'      => [
        'name'   => 'partymeister-core::backend/callbacks.callbacks',
        'values' => [
            'read',
            'write',
            'delete',
        ],
    ],
    'schedules'      => [
        'name'   => 'partymeister-core::backend/schedules.schedules',
        'values' => [
            'read',
            'write',
            'delete',
        ],
    ],
    'events'         => [
        'name'   => 'partymeister-core::backend/events.events',
        'values' => [
            'read',
            'write',
            'delete',
        ],
    ],
    'event_types'    => [
        'name'   => 'partymeister-core::backend/event_types.event_types',
        'values' => [
            'read',
            'write',
            'delete',
        ],
    ],
    'guests'         => [
        'name'   => 'partymeister-core::backend/guests.guests',
        'values' => [
            'read',
            'write',
            'delete',
        ],
    ],
    'visitors'       => [
        'name'   => 'partymeister-core::backend/visitors.visitors',
        'values' => [
            'read',
            'write',
            'delete',
        ],
    ],
    'message_groups' => [
        'name'   => 'partymeister-core::backend/message_groups.message_groups',
        'values' => [
            'read',
            'write',
            'delete',
        ],
    ],
];
