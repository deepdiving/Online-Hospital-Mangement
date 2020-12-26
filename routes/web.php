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
Route::get('blank/', function () {
    //some exprement
});

include('core.php'); // Including Accounts, Expanse, User Management, Tax management ETC..
include('pharmacy.php');
include('diagnostic.php'); //Including appointment system
include('lab.php');
include('hospital.php');
include('hrm.php');