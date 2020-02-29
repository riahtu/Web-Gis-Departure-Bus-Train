<?php

Route::get('/', 'WelcomeController@index')->name('index');
Route::post('/login', 'WelcomeController@login')->name('login');
Route::get('/logout', 'WelcomeController@logout');
Route::post('/route', 'WelcomeController@route');

Route::group(['middleware' => 'authCekLogin'], function(){
	Route::get('/place', 'PlaceController@index')->name('place');
	Route::get('/addPlace', 'PlaceController@add')->name('addPlace');
	Route::post('/addPlace', 'PlaceController@addProses');
	Route::get('/editPlace/{id}', 'PlaceController@edit');
	Route::put('/editPlace', 'PlaceController@editProses');
	Route::get('/deletePlace/{id}', 'PlaceController@delete');
});