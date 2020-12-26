<?php

Route::group(['prefix' => 'lab'], function () {
    Route::get('test/list','laboratory\LabReportController@testList');
    Route::get('make/report/{invoice}','laboratory\LabReportController@labRport');
    Route::get('report/list','laboratory\LabReportController@reportList');
    Route::get('invoice/{invoice}','laboratory\LabReportController@invoice');
    Route::get('void/list','laboratory\LabReportController@voided');
    Route::post('void/{id}','laboratory\LabReportController@void');
});
Route::resource('laboratory','laboratory\LabReportController');