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

Route::get('/', function () {
    return view('auth.login');
});


// Authentication Routes...
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@authenticate');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function() {
    Route::resource('indices', 'IndexController');
    Route::resource('indicators', 'IndicatorController');
    Route::get('indicators/{indicator}/clonar', 'IndicatorController@clonar')->name('indicators.clone');
    Route::resource('groups', 'GroupController');
    Route::get('calculations', 'CalculationController@index')->name('calculations.index');
    Route::get('calculations/{indicator}/create', 'CalculationController@create')->name('calculations.create');
    Route::get('calculations/{indicator}/show', 'CalculationController@showHistory')->name('calculations.show-history');
    Route::delete('calculations/{calculation}', 'CalculationController@destroy')->name('calculations.destroy')->middleware('adm');
    
    Route::post('calculations/{indicator}', 'CalculationController@store')->name('calculations.store');
    Route::get('historics','HistoricController@index')->name('historics.index');
    Route::put('historics/validar','HistoricController@validar')->name('historics.validar');
  

    Route::get('/users-ldap', 'UserController@usersLdap');
    Route::get('/militares-json', 'UserController@getMilitaresJson');
    Route::resource('users', 'UserController');
    Route::get('/atualizarDatasFimCalculations', 'CalculationController@atualizarTodosCalculations');



});
