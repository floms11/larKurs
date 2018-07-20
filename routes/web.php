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


Route::get('/larKurs/triger',        'PagesController@trigerReg');
Route::get('/larKurs/triger/{page}', 'PagesController@triger');


Route::get('/larKurs/',              'PagesController@start');
Route::get('/larKurs/start',         'PagesController@start');


Route::get('/larKurs/text', 	     'PagesController@text');
Route::get('/larKurs/summ', 	     'PagesController@summ');
Route::get('/larKurs/languages',     'PagesController@languages');
Route::get('/larKurs/days',          'PagesController@days');
Route::get('/larKurs/video',         'PagesController@video');
Route::get('/larKurs/finish',        'PagesController@finish');

Route::get('/larKurs/restart',       'PagesController@restart');
