<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('event/{id}', 'EventController@event');

Route::get('/', 'EventController@index');
Route::post('/', 'EventController@index');

Route::get('login/', function(){
    return view('login');
});
Auth::routes();

Route::get('dashboard', 'HomeController@index')->name('home');

Route::get('dashboard/events', 'EventController@display')->name('display_events');

Route::get('dashboard/edit/{id}', 'EventController@edit')->name('edit_event');

Route::get('dashboard/create', function(){
	if(Gate::allows('organizer') && !Auth::Guest()){
    	return view('new');
	}else{
		return view('auth/login');
	}
});

Route::post('dashboard/edit/{id}', 'EventController@update')->name('update_event');

Route::post('dashboard/create', 'EventController@create')->name('new_event');

Route::post('dashboard/delete/{id}', 'EventController@delete')->name('delete_event');

Route::post('dashboard/register', 'EventController@register')->name('upgrade_user');

Route::post('event/like/{id}', 'EventController@like')->name('like');
Route::post('event/unlike/{id}', 'EventController@unlike')->name('unlike');