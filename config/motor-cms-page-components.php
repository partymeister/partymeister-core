<?php

return [
    'groups'     => [
        'partymeister-core'    => [
            'name' => 'Partymeister core',
        ],
        'partymeister-website' => [
            'name' => 'Partymeister website'
        ]
    ],
    'components' => [
        'visitor-website-registrations' => [
            'name'            => 'VisitorWebsiteRegistration',
            'description'     => 'Show VisitorWebsiteRegistration component',
            'view'            => 'partymeister-core::frontend.components.visitor-website-registration',
            'component_class' => 'Partymeister\Core\Components\ComponentVisitorWebsiteRegistrations',
            'compatibility'   => [

            ],
            'permissions'     => [

            ],
            'group'           => 'partymeister-website'
        ],
        'schedule'                      => [
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
        'visitor-list'                  => [
            'name'            => 'VisitorList',
            'description'     => 'Show VisitorList component',
            'view'            => 'partymeister-core::frontend.components.visitor-list',
            'component_class' => 'Partymeister\Core\Components\ComponentVisitorLists',
            'compatibility'   => [

            ],
            'permissions'     => [

            ],
            'group'           => 'partymeister-core'
        ],
        'visitor-login'                 => [
            'name'            => 'VisitorLogin',
            'description'     => 'Show VisitorLogin component',
            'view'            => 'partymeister-core::frontend.components.visitor-login',
            'route'           => 'component.visitor-logins',
            'component_class' => 'Partymeister\Core\Components\ComponentVisitorLogins',
            'compatibility'   => [

            ],
            'permissions'     => [

            ],
            'group'           => 'partymeister-core'
        ],
        'visitor-registration'          => [
            'name'            => 'VisitorRegistration',
            'description'     => 'Show VisitorRegistration component',
            'view'            => 'partymeister-core::frontend.components.visitor-registration',
            'component_class' => 'Partymeister\Core\Components\ComponentVisitorRegistrations',
            'compatibility'   => [

            ],
            'permissions'     => [

            ],
            'group'           => 'partymeister-core'
        ],
    ],
];
