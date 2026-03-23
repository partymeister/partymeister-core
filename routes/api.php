<?php

use Motor\Core\Http\Middleware\V2\V2ErrorHandler;
use Partymeister\Core\Http\Controllers\Api\V2;

// V2 API routes
Route::prefix('api/v2')
    ->name('v2.')
    ->middleware([V2ErrorHandler::class, 'auth:sanctum', 'bindings'])
    ->group(function () {
        Route::apiResource('event-types', V2\EventTypesController::class);
        Route::apiResource('events', V2\EventsController::class);
        Route::apiResource('schedules', V2\SchedulesController::class);
        Route::apiResource('visitors', V2\VisitorsController::class);
        Route::apiResource('guests', V2\GuestsController::class);
        Route::apiResource('callbacks', V2\CallbacksController::class);
        Route::apiResource('message-groups', V2\MessageGroupsController::class);
    });

// Legacy API routes (kept as reference)
Route::group([
    'middleware' => ['auth:api', 'bindings', 'permission'],
    'namespace'  => 'Partymeister\Core\Http\Controllers\Api',
    'prefix'     => 'api',
    'as'         => 'api.',
], function () {
    Route::apiResource('callbacks', 'CallbacksController');
    Route::apiResource('schedules', 'SchedulesController');
    Route::get('schedules/{schedule}/playlist-data', 'ScheduleSlidesController@show')
         ->name('schedules.slides.show');
    Route::post('schedules/{schedule}/playlist', 'ScheduleSlidesController@store')
         ->name('schedules.slides.store');
    Route::apiResource('events', 'EventsController');
    Route::get('events/{event}/playlist-data', 'EventPlaylistController@show')
         ->name('events.playlist-data');
    Route::post('events/{event}/playlist', 'EventPlaylistController@store')
         ->name('events.playlist.store');
    Route::apiResource('event_types', 'EventTypesController');
    Route::apiResource('guests', 'GuestsController');
    Route::apiResource('visitors', 'VisitorsController');
    Route::apiResource('message_groups', 'MessageGroupsController');
});

Route::group([
    'middleware' => ['bindings'],
    'namespace'  => 'Partymeister\Core\Http\Controllers\Api\Public',
    'prefix'     => 'api/public',
    'as'         => 'api.public.',
], function () {
    Route::apiResource('visitors', 'VisitorsController')->only(['index']);
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
