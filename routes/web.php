<?php

Route::group([
    'as' => 'backend.',
    'prefix' => 'backend',
    'namespace' => 'Partymeister\Core\Http\Controllers\Backend',
    'middleware' => [
        'web',
        'web_auth',
        'navigation',
    ],
], function () {
    Route::group(['middleware' => ['permission']], function () {
        Route::get('/', [
            'as' => 'dashboard.redirect',
            'uses' => 'DashboardController@show',
        ])->name('dashboard-redirect');
        Route::get('dashboard', 'DashboardController@show')
            ->name('dashboard.index');

        Route::resource('callbacks', 'CallbacksController');
        Route::get('callbacks/{callback}/duplicate', 'CallbacksController@duplicate')
            ->name('callbacks.duplicate');
        Route::resource('schedules', 'SchedulesController');
        Route::get('schedules/{schedule}/slides', 'Schedules\SlidesController@index')
            ->name('schedules.slides.index');
        Route::post('schedules/{schedule}/slides', 'Schedules\SlidesController@store')
            ->name('schedules.slides.store');

        Route::resource('events', 'EventsController');
        Route::get('events/{event}/duplicate', 'EventsController@duplicate')
            ->name('events.duplicate');

        Route::resource('event_types', 'EventTypesController');
        Route::resource('guests', 'GuestsController');

        Route::resource('visitors', 'VisitorsController');
        Route::resource('message-groups', 'MessageGroupsController');

        Route::get('events/{event}/playlist', 'Events\PlaylistsController@index')
            ->name('events.playlist.index');
        Route::post('events/{event}/playlist', 'Events\PlaylistsController@store')
            ->name('events.playlist.store');
    });
});

Route::group([
    'middleware' => [
        'web',
        'web_auth',
        'bindings',
        'permission',
    ],
    'namespace' => 'Partymeister\Core\Http\Controllers\Api',
    'prefix' => 'ajax',
    'as' => 'ajax.',
], function () {
    Route::get('callbacks', 'CallbacksController@index')
        ->name('callbacks.index');
});

Route::group([
    'as' => 'component.',
    'prefix' => 'component',
    'namespace' => 'Partymeister\Core\Http\Controllers\Backend\Component',
    'middleware' => [
        'web',
    ],
], function () {
    Route::get('schedules', 'ComponentSchedulesController@create')
        ->name('schedules.create');
    Route::post('schedules', 'ComponentSchedulesController@store')
        ->name('schedules.store');
    Route::get('schedules/{component_schedule}', 'ComponentSchedulesController@edit')
        ->name('schedules.edit');
    Route::patch('schedules/{component_schedule}', 'ComponentSchedulesController@update')
        ->name('schedules.update');

    Route::get('visitor-logins', 'ComponentVisitorLoginsController@create')
        ->name('visitor-logins.create');
    Route::post('visitor-logins', 'ComponentVisitorLoginsController@store')
        ->name('visitor-logins.store');
    Route::get('visitor-logins/{component_visitor_login}', 'ComponentVisitorLoginsController@edit')
        ->name('visitor-logins.edit');
    Route::patch('visitor-logins/{component_visitor_login}', 'ComponentVisitorLoginsController@update')
        ->name('visitor-logins.update');
});
