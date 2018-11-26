<?php

return [
    'groups'     => [
        'partymeister-core' => [
            'name' => 'Partymeister core',
        ],
    ],
    'components' => [
        'schedule' => [
            'name'            => 'Schedule',
            'description'     => 'Show Schedule component',
            'view'            => 'partymeister-core::frontend.components.schedule',
            'route'           => 'component.schedules',
            'component_class' => 'Partymeister\Core\Components\ComponentSchedules',
            'compatibility'   => [

            ],
            'permissions'     => [

            ],
            'group'           => 'partymeister-core'
        ],
    ],
];
