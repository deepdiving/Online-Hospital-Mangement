<?php
/****

***************** Diagonstic Module Start ******************

** */
Route::group(['prefix' => 'diagnostic'], function () {

    Route::resource('categories', 'diagnostic\TestCategoryController');

    Route::resource('testlists','diagnostic\DiagonTestListController');
    Route::get('bill/invoice/pos/{invoice}','diagnostic\BillController@invoicePos');
    Route::get('bill/invoice/a4/{invoice}','diagnostic\BillController@invoiceA4');
    Route::post('bill/void/{slug}','diagnostic\BillController@void');
    Route::get('bill/voided', 'diagnostic\BillController@voided'); 
    Route::post('bill/restore/{slug}', 'diagnostic\BillController@restore');
    Route::resource('bill','diagnostic\BillController');
    Route::post('referral/payment', 'AjaxController@referralPayment');
    Route::get('find-patient/{id}', 'AjaxController@findPatient');
    Route::get('testcount/increment/{id}', 'AjaxController@testCountIncrement');
    Route::get('testcount/decrement/{id}', 'AjaxController@testCountDecrement');
    Route::get('bill/categori-sarch/{id}', 'AjaxController@SearchbyCat');
});





//Apointment & Prescription Module----------------------------------------------------------------------------------------------------
Route::get('schedule/chart','doctor\DocScheduleController@chart');
Route::resource('schedule','doctor\DocScheduleController');
Route::get('appointment/get-time-slot/{date}/{doctor}','doctor\DocAppointmentController@getTimeSlot');
Route::get('appointment/get-time-slot-data/{scheduleId}/{date}','doctor\DocAppointmentController@getTimeSlotData');
Route::get('appointment/get-day-wise-doctor-schedule/{doctorId}/{scheduleId}/{date}','doctor\DocAppointmentController@getDaywiseDoctorSchedule');
Route::get('appointment/get-appointment/{id}','doctor\DocAppointmentController@getAppointment');
Route::post('appointment/payment','doctor\DocAppointmentController@payment')->name('appoint-payment');
Route::post('appointment-patient','doctor\DocAppointmentController@patientStore');
// Route::get('appointment-cofirmed','doctor\DocAppointmentController@patientStore');
Route::get('appointment-list','doctor\DocAppointmentController@appointmentList');
Route::get('appointed/{id}','doctor\DocAppointmentController@appointedpatient');
Route::resource('appointment','doctor\DocAppointmentController');



Route::get('prescription/list','doctor\PrescriptionController@prescriptionList');
Route::post('prescription/void/{id}','doctor\PrescriptionController@void');
Route::get('prescription/voided','doctor\PrescriptionController@voided');
Route::get('prescription/draft','doctor\PrescriptionController@draft');
Route::get('prescription/invoice/a4/{invoice}','doctor\PrescriptionController@invoiceA4');

//ajax
Route::get('prescription/patient/{id}','doctor\PrescriptionController@patient');
Route::get('prescription/new-medicine/{type}/{medicine}','doctor\PrescriptionController@newMedicine');
Route::get('medicine-test-sarch/{id}', 'doctor\PrescriptionController@SearchbyTestType');
Route::get('medicine-category-sarch/{id}', 'doctor\PrescriptionController@SearchbyMedecineType');
Route::get('prescription/medicine/{id}','doctor\PrescriptionController@medicine');
Route::get('diagon-prescription-list','diagnostic\BillController@diagonPrescriptionList');

Route::resource('prescription','doctor\PrescriptionController');

