<?php

use Illuminate\Http\Request;

// Route::post('user','UserController@register');
Route::post('auth/login','AuthController@login');

Route::group(['middleware' => 'auth:api'], function() {
	Route::post('auth/logout','AuthController@logout');

	Route::get('place','PlaceController@index');
	Route::get('place/{id}','PlaceController@placeById');
	Route::post('place','PlaceController@createPlace');
	Route::delete('place/{id}','PlaceController@deletePlace');
	Route::put('place/{id}','PlaceController@editPlace');

	Route::get('schedule','ScheduleController@index');
	Route::post('schedule','ScheduleController@createSchedule');
	Route::delete('schedule/{id}','ScheduleController@deleteSchedule');

	Route::get('route/search/{from_place_id}/{to_place_id}','RouteController@search');
	Route::get('route/search/{from_place_id}/{to_place_id}/{departure_time}','RouteController@search');
	Route::post('route/selection','RouteController@createHistory');
	Route::get('route/historyWhereUser/{user}','RouteController@getHistoryWhereUser');
	Route::get('route/HistoryWhereUserOther/{user}','RouteController@getHistoryWhereUserOther');
});