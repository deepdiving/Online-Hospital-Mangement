<?php

/****

***************** Hospital Module Start ******************

** */
Route::group(['prefix' => 'hospital'], function () {
    Route::get('beds/bed/status','hospital\HmsBedsController@status');
    Route::resource('beds/bedtype','hospital\HmsBedTypesController');
    Route::resource('beds/bed','hospital\HmsBedsController');
    Route::resource('services/servicecategory','hospital\HmsServiceCategoriesController');
    Route::resource('services/service','hospital\HmsServicesController');

    Route::get('admission/discharge/{slug}','hospital\HmsAdmissionsController@discharge');
    Route::post('admission/discharge/{slug}','hospital\HmsAdmissionsController@postdischarge');
    Route::post('admission/void/{slug}','hospital\HmsAdmissionsController@void');
    Route::get('admission/voided', 'hospital\HmsAdmissionsController@voided');
    Route::post('admission/restore/{slug}', 'hospital\HmsAdmissionsController@restore');
    Route::resource('admission','hospital\HmsAdmissionsController');


    Route::get('admission/service-search/{id}', 'AjaxController@SearchbyServiceCat');
    Route::get('admission/invoice/a4/{invoice}','hospital\HmsAdmissionsController@invoiceA4');
    Route::get('admission/invoice/pos/{invoice}','hospital\HmsAdmissionsController@invoicePos');
    Route::get('admission/voided', 'hospital\HmsAdmissionsController@voided');
    Route::get('admission/discharge-list', 'hospital\HmsAdmissionsController@dischargelist');
    Route::get('discharge-list', 'hospital\HmsAdmissionsController@dischargelist');

    Route::resource('operation/type','hospital\HmsOperationTypeController');
    Route::resource('operation/service','hospital\HmsOperationServiceController');
    route::get('operation/invoice/a4/{invoice}','hospital\HmsOperationController@invoiceA4');
    route::get('operation/invoice/pos/{invoice}','hospital\HmsOperationController@invoicePos');
    route::POST('operation/void/{slug}','hospital\HmsOperationController@void');
    route::get('operation/voided','hospital\HmsOperationController@voided');
    Route::resource('operation','hospital\HmsOperationController');

    //ajax call
    Route::get('hmstypeservice/{typeid}', 'AjaxController@hmsTypeService');
    Route::get('hmsoperationprice/{serviceId}', 'AjaxController@hmsOperationServicePrice');
    Route::get('find-patient/{id}', 'AjaxController@findAdmissionPatient');

    //Emergency Module

    Route::post('emergency/void/{slug}','hospital\HmsEmergencyController@void');
    Route::get('emergency/invoice/a4/{invoice}','hospital\HmsEmergencyController@invoiceA4');
    Route::get('emergency/invoice/pos/{invoice}','hospital\HmsEmergencyController@invoicePos');
    Route::get('emergency/voided', 'hospital\HmsEmergencyController@voided');
    Route::resource('emergency','hospital\HmsEmergencyController');
    Route::get('bedcharge/invoice/a4/{invoice}','hospital\BedChargeCollectionController@invoiceA4');
    Route::get('bedcharge/invoice/pos/{invoice}','hospital\BedChargeCollectionController@invoicePos');
    Route::resource('bedcharge','hospital\BedChargeCollectionController');
});