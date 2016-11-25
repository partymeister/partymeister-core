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
], function ()
{

	Route::group(['middleware' => ['permission']], function ()
	{
	});
});
