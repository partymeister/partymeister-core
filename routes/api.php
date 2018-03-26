<?php
Route::group([
    'middleware' => [ 'auth:api', 'bindings', 'permission' ],
    'namespace'  => 'Partymeister\Core\Http\Controllers\Api',
    'prefix'     => 'api',
    'as'         => 'api.',
], function () {
    //Route::resource('callbacks', 'CallbacksController');
    //Route::resource('schedules', 'SchedulesController');
    //Route::resource('events', 'EventsController');
    //Route::resource('event_types', 'EventTypesController');
    Route::resource('guests', 'GuestsController');
    //Route::resource('visitors', 'VisitorsController');
});

Route::group([
    'middleware' => [ 'web', 'web_auth', 'bindings', 'permission' ],
    'namespace'  => 'Partymeister\Core\Http\Controllers\Api',
    'prefix'     => 'ajax',
    'as'         => 'ajax.',
], function () {
    Route::get('schedules/{schedule}', 'SchedulesController@show')->name('schedules.show');
    Route::post('guests/scan_tickets', 'Guests\ScanTicketsController@index')->name('guests.scan_tickets.index');
});
