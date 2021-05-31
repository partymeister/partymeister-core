<?php

return [
    'items' => [
        100 => [
            'slug'        => 'partymeister',
            'name'        => 'partymeister-core.global.partymeister',
            'icon'        => 'calendar',
            'route'       => null,
            'roles'       => ['SuperAdmin'],
            'permissions' => ['partymeister.read'],
            'items'       => [
                100 => [ // <-- !!! replace 865 with your own sort position !!!
                         'slug'        => 'callbacks',
                         'name'        => 'partymeister-core.callbacks.callbacks',
                         'icon'        => 'fa fa-plus',
                         'route'       => 'admin.partymeister-core.callbacks',
                         'roles'       => ['SuperAdmin'],
                         'permissions' => ['callbacks.read'],
                ],
                200 => [ // <-- !!! replace 408 with your own sort position !!!
                         'slug'        => 'schedules',
                         'name'        => 'partymeister-core.schedules.schedules',
                         'icon'        => 'fa fa-plus',
                         'route'       => 'admin.partymeister-core.schedules',
                         'roles'       => ['SuperAdmin'],
                         'permissions' => ['schedules.read'],
                ],
                300 => [ // <-- !!! replace 865 with your own sort position !!!
                         'slug'        => 'events',
                         'name'        => 'partymeister-core.events.events',
                         'icon'        => 'fa fa-plus',
                         'route'       => 'admin.partymeister-core.events',
                         'roles'       => ['SuperAdmin'],
                         'permissions' => ['events.read'],
                ],
                400 => [ // <-- !!! replace 391 with your own sort position !!!
                         'slug'        => 'event_types',
                         'name'        => 'partymeister-core.event_types.event_types',
                         'icon'        => 'fa fa-plus',
                         'route'       => 'admin.partymeister-core.event-types',
                         'roles'       => ['SuperAdmin'],
                         'permissions' => ['event_types.read'],
                ],
                500 => [ // <-- !!! replace 332 with your own sort position !!!
                         'slug'        => 'guests',
                         'name'        => 'partymeister-core.guests.guests',
                         'icon'        => 'fa fa-plus',
                         'route'       => 'admin.partymeister-core.guests',
                         'roles'       => ['SuperAdmin'],
                         'permissions' => ['guests.read'],
                ],
                600 => [ // <-- !!! replace 226 with your own sort position !!!
                         'slug'        => 'visitors',
                         'name'        => 'partymeister-core.visitors.visitors',
                         'icon'        => 'fa fa-plus',
                         'route'       => 'admin.partymeister-core.visitors',
                         'roles'       => ['SuperAdmin'],
                         'permissions' => ['visitors.read'],
                ],
                700 => [ // <-- !!! replace 701 with your own sort position !!!
                         'slug'        => 'message_groups',
                         'name'        => 'partymeister-core.message-groups.message_groups',
                         'icon'        => 'fa fa-plus',
                         'route'       => 'backend.message-groups.index',
                         'roles'       => ['SuperAdmin'],
                         'permissions' => ['message_groups.read'],
                ],
            ],
        ],
    ],
];
