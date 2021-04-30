<?php

return [
    'items' => [
        100 => [
            'slug'        => 'partymeister',
            'name'        => 'partymeister-core::backend/global.partymeister',
            'icon'        => 'fa fa-home',
            'route'       => null,
            'roles'       => ['SuperAdmin'],
            'permissions' => ['partymeister.read'],
            'items'       => [
                100 => [ // <-- !!! replace 865 with your own sort position !!!
                         'slug'        => 'callbacks',
                         'name'        => 'partymeister-core::backend/callbacks.callbacks',
                         'icon'        => 'fa fa-plus',
                         'route'       => 'backend.callbacks.index',
                         'roles'       => ['SuperAdmin'],
                         'permissions' => ['callbacks.read'],
                ],
                200 => [ // <-- !!! replace 408 with your own sort position !!!
                         'slug'        => 'schedules',
                         'name'        => 'partymeister-core::backend/schedules.schedules',
                         'icon'        => 'fa fa-plus',
                         'route'       => 'backend.schedules.index',
                         'roles'       => ['SuperAdmin'],
                         'permissions' => ['schedules.read'],
                ],
                300 => [ // <-- !!! replace 865 with your own sort position !!!
                         'slug'        => 'events',
                         'name'        => 'partymeister-core::backend/events.events',
                         'icon'        => 'fa fa-plus',
                         'route'       => 'backend.events.index',
                         'roles'       => ['SuperAdmin'],
                         'permissions' => ['events.read'],
                ],
                400 => [ // <-- !!! replace 391 with your own sort position !!!
                         'slug'        => 'event_types',
                         'name'        => 'partymeister-core::backend/event_types.event_types',
                         'icon'        => 'fa fa-plus',
                         'route'       => 'backend.event_types.index',
                         'roles'       => ['SuperAdmin'],
                         'permissions' => ['event_types.read'],
                ],
                500 => [ // <-- !!! replace 332 with your own sort position !!!
                         'slug'        => 'guests',
                         'name'        => 'partymeister-core::backend/guests.guests',
                         'icon'        => 'fa fa-plus',
                         'route'       => 'backend.guests.index',
                         'roles'       => ['SuperAdmin'],
                         'permissions' => ['guests.read'],
                ],
                600 => [ // <-- !!! replace 226 with your own sort position !!!
                         'slug'        => 'visitors',
                         'name'        => 'partymeister-core::backend/visitors.visitors',
                         'icon'        => 'fa fa-plus',
                         'route'       => 'backend.visitors.index',
                         'roles'       => ['SuperAdmin'],
                         'permissions' => ['visitors.read'],
                ],
                700 => [ // <-- !!! replace 701 with your own sort position !!!
                         'slug'        => 'message_groups',
                         'name'        => 'partymeister-core::backend/message-groups.message_groups',
                         'icon'        => 'fa fa-plus',
                         'route'       => 'backend.message-groups.index',
                         'roles'       => ['SuperAdmin'],
                         'permissions' => ['message_groups.read'],
                ],
            ],
        ],
    ],
];
