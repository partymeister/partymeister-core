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
});
