<?php

return [
    'callbacks' => 'Callbacks',
    'callback'  => 'Callback',
    'new'       => 'Create callback',
    'edit'      => 'Edit callback',
    'save'      => 'Save callback',
    'created'   => 'Callback created',
    'updated'   => 'Callback updated',
    'deleted'   => 'Callback deleted',

    'name'              => 'Name',
    'title'             => 'Title',
    'body'              => 'Body',
    'link'              => 'Link',
    'hash'              => 'Hash',
    'embargo_until'     => 'Embargo until',
    'fired_at'          => 'Fired at',
    'payload'           => 'Payload',
    'is_timed'          => 'Is timed',
    'has_fired'         => 'Has fired',
    'action'            => 'Action',
    'notification_info' => 'Notification',
    'time_info'         => 'Timing',

    'actions'      => [
        'notification'           => 'Send notification',
        'live'                   => 'Advance live voting',
        'live_with_notification' => 'Adanvce live voting and send notification'
    ],
    'destination'  => 'Destination',
    'destinations' => [
        'orga'         => 'Orga (#revisionorga / slack)',
        'nowplaying'   => 'Now playing (IRC #revision)',
        'general'      => 'General (public)',
        'competitions' => 'Competitions (public)',
        'seminars'     => 'Seminars (public)',
        'deadlines'    => 'Deadlines (public)',
        'events'       => 'Events (public)',
        'nightshuttle' => 'Nightshuttle (public)',
        'location'     => 'Location (public)',
        'ios'          => 'iOS (public)',
        'android'      => 'Android (public)',
        'testing'      => 'TESTING'
    ]
];
