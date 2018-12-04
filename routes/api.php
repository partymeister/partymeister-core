<?php
Route::group([
    'middleware' => [ 'auth:api', 'bindings', 'permission' ],
    'namespace'  => 'Partymeister\Core\Http\Controllers\Api',
    'prefix'     => 'api',
    'as'         => 'api.',
], function () {
    //Route::resource('callbacks', 'CallbacksController');
    //Route::resource('schedules', 'SchedulesController');
    Route::resource('events', 'EventsController');
    //Route::resource('event_types', 'EventTypesController');
    Route::resource('guests', 'GuestsController');
    //Route::resource('visitors', 'VisitorsController');
    Route::resource('message-groups', 'MessageGroupsController');
});

Route::group([
    'middleware' => [ 'bindings' ],
    'namespace'  => 'Partymeister\Core\Http\Controllers\Api',
    'prefix'     => 'api',
    'as'         => 'api.',
], function () {
    Route::post('callback/single', 'Callbacks\SendController@single')->name('api.callback.single');
    Route::get('callback/{hash}', 'Callbacks\SendController@callback')->name('api.callback.callback');
});

Route::group([
    'middleware' => [ 'web', 'web_auth', 'bindings' ],
    'namespace'  => 'Partymeister\Core\Http\Controllers\Api',
    'prefix'     => 'ajax',
    'as'         => 'ajax.',
], function () {
    Route::get('schedules/{schedule}', 'SchedulesController@show')->name('schedules.show');
    Route::post('guests/scan_tickets', 'Guests\ScanTicketsController@index')->name('guests.scan_tickets.index');
});
