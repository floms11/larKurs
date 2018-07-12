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


Route::get('/larKurs/triger',        'pagesController@trigerReg');
Route::get('/larKurs/triger/{page}', 'pagesController@triger');


Route::get('/larKurs/',              'pagesController@start');
Route::get('/larKurs/start',         'pagesController@start');


Route::get('/larKurs/text', 	     'pagesController@text');
Route::get('/larKurs/summ', 	     'pagesController@summ');
Route::get('/larKurs/languages',     'pagesController@languages');
Route::get('/larKurs/days',          'pagesController@days');
Route::get('/larKurs/video',         'pagesController@video');
Route::get('/larKurs/finish',        'pagesController@finish');

Route::get('/larKurs/restart',       'pagesController@restart');