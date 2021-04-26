<?php
Route::group([
    'middleware' => ['auth:api', 'bindings', 'permission'],
    'namespace'  => 'Partymeister\Core\Http\Controllers\Api',
    'prefix'     => 'api',
    'as'         => 'api.',
], function () {
    Route::apiResource('callbacks', 'CallbacksController');
    Route::apiResource('schedules', 'SchedulesController');
    Route::apiResource('events', 'EventsController');
    Route::apiResource('event_types', 'EventTypesController');
    Route::apiResource('guests', 'GuestsController');
    Route::apiResource('visitors', 'VisitorsController');
    Route::apiResource('message_groups', 'MessageGroupsController');
});

Route::group([
    'middleware' => ['bindings'],
    'namespace'  => 'Partymeister\Core\Http\Controllers\ApiRPC',
    'prefix'     => 'api-rpc',
    'as'         => 'api-rpc.',
], function () {
    Route::post('callback/single', 'Callbacks\SendController@single')
         ->name('callback.single');
    Route::get('callback/{hash}', 'Callbacks\SendController@callback')
         ->name('callback.callback');
});

Route::group([
    'middleware' => ['web', 'web_auth', 'bindings'],
    'namespace'  => 'Partymeister\Core\Http\Controllers\Api',
    'prefix'     => 'ajax',
    'as'         => 'ajax.',
], function () {
    Route::get('schedules/{schedule}', 'SchedulesController@show')
         ->name('schedules.show');
});

Route::group([
    'middleware' => ['web', 'web_auth', 'bindings'],
    'namespace'  => 'Partymeister\Core\Http\Controllers\ApiRPC',
    'prefix'     => 'ajax',
    'as'         => 'ajax.',
], function () {
    Route::post('guests/scan_tickets', 'Guests\ScanTicketsController@index')
         ->name('guests.scan_tickets.index');
});
