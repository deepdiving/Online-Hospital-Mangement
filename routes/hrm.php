
<?php
//hrm start


Route::resource('positions','hrm\PositionController');
Route::resource('department','hrm\DepartmentController');
Route::resource('salary/structure','hrm\SalaryStructureController');
Route::resource('department','hrm\DepartmentController');
Route::resource('salary/structure','hrm\SalaryStructureController');
Route::get('salary/list','hrm\SalaryGenerateController@salaryList'); 
Route::get('salary/slip/{id}','hrm\SalaryGenerateController@salarySlip');
Route::post('salary/status/{id}','hrm\SalaryGenerateController@paidSalary');
Route::resource('salary/generate','hrm\SalaryGenerateController'); 
Route::resource('employee/salary/structure','hrm\EmpSalaryStructureController'); 
Route::resource('position','hrm\PositionController');
Route::get('attendence/list','hrm\AttendanceController@list'); 
Route::resource('attendence','hrm\AttendanceController');
Route::resource('employee','hrm\EmployeeController');

Route::get('attendance-form/', 'Pharma\exportImportConrtoller@attendanceExportForm');
Route::post('attendance-form/import', 'Pharma\exportImportConrtoller@attendanceImport');
