<?php

Route::get('locale/{locale}', function ($locale) {
    Session::put('locale',$locale);
    DB::table('site_settings')->update(['language'=>$locale]);
    Pharma::activities("Changes", "Language", "Change language to ".$locale);
    return redirect()->back();
});

Route::get('404', function () {
    return view('frontend.404');
})->name('404');


// Forntend Authorization pages , can access all user;
Route::get('/', 'HomeController@index');
Route::get('login', 'HomeController@login');
Route::post('login', 'HomeController@process_login')->name('process_login');
Route::get('register', 'HomeController@register');
Route::post('process_register', 'HomeController@process_register')->name('process_register');
Route::get('logout', 'HomeController@logout');
Route::get('password_reset', 'HomeController@password_reset');
Route::post('password_reset', 'HomeController@process_password_reset');
Route::get('confirm_password_reset/{id}/{code}', 'HomeController@confirm_password_reset');
Route::post('confirm_password_reset/{id}/{code}', 'HomeController@process_confirm_password_reset');







/****

***************** Admin Module Start ******************

****/

//Only Authorized User Allowed

Route::get('dashboard', 'UserController@dashboard');
Route::get('myprofile', 'UserController@myProfile')->name('myprofile');
Route::post('myprofile', 'UserController@updateMyProfile');

Route::group(['prefix' => 'users'], function () {
    //Manage Users
    Route::get('/', 'UserController@index');
    Route::get('create', 'UserController@userCreate');
    Route::post('store', 'UserController@userStore');
    Route::get('/{id}/edit', 'UserController@userEdit');
    Route::post('/{id}/update', 'UserController@userUpdate');
    Route::post('/{id}/delete', 'UserController@userDelete');

    //manage permissions
    Route::get('permissions', 'PermissionController@index');
    Route::get('permission/create', 'PermissionController@create');
    Route::get('permission/parent_show', 'PermissionController@parent_show');
    Route::post('permission/store', 'PermissionController@store')->name('permission.store');
    Route::get('permission/{id}/edit', 'PermissionController@edit');
    Route::post('permission/{id}/update', 'PermissionController@update');
    // Route::get('permission/{id}/delete', 'PermissionController@deletePermission');

    //manage roles
    Route::get('roles', 'UserController@indexRole')->name('roles');
    Route::get('role/create', 'UserController@createRole')->name('createRole');
    Route::post('role/store', 'UserController@storeRole')->name('storeRole');
    Route::get('role/{id}/edit', 'UserController@editRole');
    Route::post('role/{id}/update', 'UserController@updateRole')->name('updateRole');
    Route::post('role/{id}/delete', 'UserController@deleteRole');

    //User activites logs
    Route::get('activities', 'ActivityController@index');
    Route::get('activities/{id}/delete', 'ActivityController@delete');
    // user notification
    Route::get('notification', 'NotificationController@index');
    Route::get('notification/{id}/delete', 'NotificationController@delete');
});

Route::get('mailbox', 'EmailTemplateController@mailbox');
Route::get('mailbox/detail/{id}', 'EmailTemplateController@mailbox_detail');
Route::post('mailbox_delete/', 'EmailTemplateController@mailbox_delete')->name('maildelete');
Route::resource('emailtemplate', 'EmailTemplateController');

Route::group(['prefix' => 'settings'], function () {
    Route::get('system-setting/general', 'SiteSettingController@general');
    Route::post('system-setting/general', 'SiteSettingController@generalUpdate');
    Route::get('system-setting/site', 'SiteSettingController@site');
    Route::post('system-setting/site', 'SiteSettingController@siteUpdate');
});


Route::get('notification/{id}/update', 'AjaxController@updateNotification');
Route::get('users/role/{id}/show', 'AjaxController@showParmission');
Route::get('purchase/product/{slug}', 'AjaxController@purchaseProduct');
Route::get('sale/customer/{id}', 'AjaxController@getCustomerInfo');
Route::get('purchase/manufacturersProduct/{id}', 'AjaxController@manufacturersProduct');
Route::get('products/change-status/{id}/{status}', 'AjaxController@changeProductStatus');
//UI
Route::get('togglesidebar', 'AjaxController@uiToggleSidebar');
Route::get('theme-switcher/{theme}', 'AjaxController@uiColorSwitcher');


Route::group(['prefix' => 'bankaccount'], function () {
    Route::get('transaction/create', 'BankAccountController@createTransaction');
    Route::post('transaction/store', 'BankAccountController@storeTransaction');
    Route::get('transaction/', 'BankAccountController@indexTransaction');
});
Route::resource('bankaccount', 'BankAccountController');


Route::group(['prefix' => 'expenses'], function () {
    Route::get('category/create', 'ExpenseController@createExpenseCategory');
    Route::get('category/', 'ExpenseController@indexExpenseCategory');
    Route::post('category/store', 'ExpenseController@storeExpenseCategory');
    Route::get('category/{id}/edit', 'ExpenseController@editExpenseCategory');
    Route::put('category/{id}', 'ExpenseController@updateExpenseCategory');
});
Route::post('expense/void/{id}','ExpenseController@void');
Route::get('expense/voided','ExpenseController@voided');
Route::resource('expense', 'ExpenseController');
Route::resource('bankaccount', 'BankAccountController');

Route::group(['prefix' => 'accounts'], function () {
    Route::get('transaction/makepayment', 'TransationController@makepayment');
    Route::get('transaction/receivepayment', 'TransationController@receivedpayment');
    Route::get('due','DueCollectionController@index');
    Route::get('due/invoice/a4/{invoice}','DueCollectionController@invoiceA4');
    Route::get('due/invoice/pos/{invoice}','DueCollectionController@invoicePos');
    Route::resource('transaction', 'TransationController');

});


Route::resource('patient', 'PatientController');
Route::resource('doctor','DoctorController');
Route::post('doctor/payment', 'AjaxController@doctorPayment');
Route::resource('referral/category','ReferralCategoryController');
Route::resource('referral','ReferralController');

// Route::group(['prefix' => 'dues'],function(){
//     Route::get('due','DueCollectionController@index');
//     Route::get('due/invoice/a4/{invoice}','DueCollectionController@invoiceA4');
//     Route::get('due/invoice/pos/{invoice}','DueCollectionController@invoicePos');

// });
Route::resource('dues','DueCollectionController');


Route::resource('medicines', 'doctor\PreMedicineController');
Route::group(['prefix' => 'doctor'], function () {

  Route::resource('medicine/type', 'doctor\PreMedicineTypeController');
  Route::resource('medicine/routine', 'doctor\PreRoutineController');

});

Route::resource('departments','DepartmentController');


//Asset start....
Route::resource('asset/category', 'AssetCategoryController');
Route::resource('asset/location', 'AssetLocationController');
Route::resource('asset/equipment', 'AssetEquipmentController');
//Asset end....