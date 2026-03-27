<?php

use Motor\Core\Http\Middleware\V2\V2ErrorHandler;
use Partymeister\Core\Http\Controllers\Api\V2;
use Partymeister\Core\Http\Controllers\Api\V2\Auth;
use Partymeister\Core\Http\Controllers\Api\V2\PublicApi;
use Partymeister\Core\Http\Controllers\Api\V2\Rpc;

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

// V2 RPC routes
Route::prefix('api/v2/rpc')
    ->name('v2.rpc.')
    ->middleware([V2ErrorHandler::class, 'auth:sanctum', 'bindings'])
    ->group(function () {
        Route::post('callbacks/{callback}/fire', Rpc\Callbacks\FireController::class)->name('callbacks.fire');
        Route::post('callbacks/send-test', Rpc\Callbacks\SendTestController::class)->name('callbacks.send-test');
        Route::post('guests/scan-ticket', Rpc\Guests\ScanTicketController::class)->name('guests.scan-ticket');
        Route::get('events/{event}/playlist', [Rpc\Events\PlaylistController::class, 'show'])->name('events.playlist.show');
        Route::post('events/{event}/playlist', [Rpc\Events\PlaylistController::class, 'store'])->name('events.playlist.store');
        Route::get('schedules/{schedule}/playlist', [Rpc\Schedules\PlaylistController::class, 'show'])->name('schedules.playlist.show');
        Route::post('schedules/{schedule}/playlist', [Rpc\Schedules\PlaylistController::class, 'store'])->name('schedules.playlist.store');
    });

// V2 Auth routes (visitor authentication)
Route::prefix('api/v2/auth')
    ->name('v2.auth.')
    ->middleware([V2ErrorHandler::class])
    ->group(function () {
        Route::post('login', [Auth\LoginController::class, 'store'])->middleware('throttle:5,1')->name('login');
        Route::post('register', [Auth\RegisterController::class, 'store'])->middleware('throttle:5,1')->name('register');
        Route::post('logout', [Auth\LogoutController::class, 'store'])->middleware('auth:sanctum')->name('logout');
        Route::post('password/forgot', [Auth\PasswordForgotController::class, 'store'])->middleware('throttle:3,1')->name('password.forgot');
        Route::post('password/reset', [Auth\PasswordResetController::class, 'store'])->middleware('throttle:5,1')->name('password.reset');
        Route::get('me', [Auth\MeController::class, 'show'])->middleware('auth:sanctum')->name('me');
    });

// V2 Public routes (unauthenticated, read-only)
Route::prefix('api/v2/public')
    ->name('v2.public.')
    ->middleware([V2ErrorHandler::class, 'bindings'])
    ->group(function () {
        Route::get('event-types', [PublicApi\EventTypesController::class, 'index'])->name('event-types.index');
        Route::get('event-types/{event_type}', [PublicApi\EventTypesController::class, 'show'])->name('event-types.show');
        Route::get('events', [PublicApi\EventsController::class, 'index'])->name('events.index');
        Route::get('events/{event}', [PublicApi\EventsController::class, 'show'])->name('events.show');
        Route::get('schedules', [PublicApi\SchedulesController::class, 'index'])->name('schedules.index');
        Route::get('schedules/{schedule}', [PublicApi\SchedulesController::class, 'show'])->name('schedules.show');
        Route::get('visitors', [PublicApi\VisitorsController::class, 'index'])->name('visitors.index');
    });

// Legacy API routes (kept as reference)
Route::group([
    'middleware' => ['auth:api', 'bindings', 'permission'],
    'namespace' => 'Partymeister\Core\Http\Controllers\Api',
    'prefix' => 'api',
    'as' => 'api.',
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
    'namespace' => 'Partymeister\Core\Http\Controllers\Api\Public',
    'prefix' => 'api/public',
    'as' => 'api.public.',
], function () {
    Route::apiResource('visitors', 'VisitorsController')->only(['index']);
});

Route::group([
    'middleware' => ['bindings'],
    'namespace' => 'Partymeister\Core\Http\Controllers\ApiRPC',
    'prefix' => 'api-rpc',
    'as' => 'api-rpc.',
], function () {
    Route::post('callback/single', 'Callbacks\SendController@single')
        ->name('callback.single');
    Route::get('callback/{hash}', 'Callbacks\SendController@callback')
        ->name('callback.callback');
});

Route::group([
    'middleware' => ['web', 'web_auth', 'bindings'],
    'namespace' => 'Partymeister\Core\Http\Controllers\Api',
    'prefix' => 'ajax',
    'as' => 'ajax.',
], function () {
    Route::get('schedules/{schedule}', 'SchedulesController@show')
        ->name('schedules.show');
});

Route::group([
    'middleware' => ['web', 'web_auth', 'bindings'],
    'namespace' => 'Partymeister\Core\Http\Controllers\ApiRPC',
    'prefix' => 'ajax',
    'as' => 'ajax.',
], function () {
    Route::post('guests/scan_tickets', 'Guests\ScanTicketsController@index')
        ->name('guests.scan_tickets.index');
});
