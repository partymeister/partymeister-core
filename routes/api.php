<?php
Route::group([
    'middleware' => [ 'auth:api', 'bindings', 'permission' ],
    'namespace'  => 'Partymeister\Core\Http\Controllers\Api',
    'prefix'     => 'api',
    'as'         => 'api.',
], function () {
});
