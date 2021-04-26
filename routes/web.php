<?php

Route::group([
    'as'         => 'backend.',
    'prefix'     => 'backend',
    'namespace'  => 'Partymeister\Core\Http\Controllers\Backend',
    'middleware' => [
        'web',
        'web_auth',
        'navigation'
    ]
], function () {
    Route::group([ 'middleware' => [ 'permission' ] ], function () {
        Route::get('/', [
            'as'   => 'dashboard.index',
            'uses' => 'DashboardController@show'
        ]);
        Route::get('dashboard', 'DashboardController@show')->name('dashboard.index');

        Route::resource('callbacks', 'CallbacksController');
        Route::get('callbacks/{callback}/duplicate', 'CallbacksController@duplicate')->name('callbacks.duplicate');
        Route::resource('schedules', 'SchedulesController');
        Route::get('schedules/{schedule}/slides', 'Schedules\SlidesController@index')->name('schedules.slides.index');
        Route::post('schedules/{schedule}/slides', 'Schedules\SlidesController@store')->name('schedules.slides.store');

        Route::resource('events', 'EventsController');
        Route::get('events/{event}/duplicate', 'EventsController@duplicate')->name('events.duplicate');

        Route::resource('event_types', 'EventTypesController');
        Route::resource('guests', 'GuestsController');

        Route::resource('visitors', 'VisitorsController');
        Route::resource('message-groups', 'MessageGroupsController');
    });
});

Route::group([
    'middleware' => [
        'web',
        'web_auth',
        'bindings',
        'permission'
    ],
    'namespace'  => 'Partymeister\Core\Http\Controllers\Api',
    'prefix'     => 'ajax',
    'as'         => 'ajax.',
], function () {
    Route::get('callbacks', 'CallbacksController@index')->name('callbacks.index');
});

//Route::get('infodesk.json', 'Partymeister\Core\Http\Controllers\Api\LegacyController@infodesk')->name('infodesk');
//Route::get('visitors.json', 'Partymeister\Core\Http\Controllers\Api\LegacyController@visitors')->name('visitors');
//Route::get('timetable.json', 'Partymeister\Core\Http\Controllers\Api\LegacyController@timetable')->name('timetable');

// Only add the route group if you don't already have one for the given namespace
Route::group([
    'as'         => 'component.',
    'prefix'     => 'component',
    'namespace'  => 'Partymeister\Core\Http\Controllers\Backend\Component',
    'middleware' => [
        'web',
    ]
], function () {
    // You only need this part if you already have a component group for the given namespace
    Route::get('schedules', 'ComponentSchedulesController@create')->name('schedules.create');
    Route::post('schedules', 'ComponentSchedulesController@store')->name('schedules.store');
    Route::get('schedules/{component_schedule}', 'ComponentSchedulesController@edit')->name('schedules.edit');
    Route::patch('schedules/{component_schedule}', 'ComponentSchedulesController@update')->name('schedules.update');

    Route::get('visitor-logins', 'ComponentVisitorLoginsController@create')->name('visitor-logins.create');
    Route::post('visitor-logins', 'ComponentVisitorLoginsController@store')->name('visitor-logins.store');
    Route::get('visitor-logins/{component_visitor_login}', 'ComponentVisitorLoginsController@edit')
         ->name('visitor-logins.edit');
    Route::patch('visitor-logins/{component_visitor_login}', 'ComponentVisitorLoginsController@update')
         ->name('visitor-logins.update');
});
