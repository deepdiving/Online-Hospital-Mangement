<?php

/****

***************** Pharma Module Start ******************

****/

Route::group(['prefix' => 'products'], function () {
    Route::resource('category', 'Pharma\CategoryController');
    Route::resource('type', 'Pharma\ProductTypeController');
    Route::resource('unit', 'Pharma\UnitController');
    Route::resource('tax', 'Pharma\ProductTaxController');
    //products
    Route::get('product/barcode/{product}', 'Pharma\ProductController@barcode');
    Route::resource('product', 'Pharma\ProductController');
    //Export Import
    Route::get('export-import/', 'Pharma\exportImportConrtoller@exportImport');
    Route::get('item-export-form/', 'Pharma\exportImportConrtoller@itemExportForm');
    Route::get('item-export/', 'Pharma\exportImportConrtoller@itemExport');
    Route::post('item-import/', 'Pharma\exportImportConrtoller@itemImport');
    Route::get('category-export/', 'Pharma\exportImportConrtoller@categoryExport');
    Route::get('unit-export/', 'Pharma\exportImportConrtoller@unitExport');
    Route::get('product-type-export/', 'Pharma\exportImportConrtoller@productTypeExport');
    Route::get('manufacturer-export/', 'Pharma\exportImportConrtoller@manufacturerExport');
    Route::get('batch-export-form/', 'Pharma\exportImportConrtoller@batchExportForm');
    Route::get('batch-export/', 'Pharma\exportImportConrtoller@batchExport');
    Route::post('batch-import/', 'Pharma\exportImportConrtoller@batchImport');
});




Route::group(['prefix' => 'manufacturers'], function () {
    Route::resource('manufacturer', 'Pharma\ManufacturerController');
});

Route::group(['prefix' => 'purchase'], function () {
    Route::post('restore/{slug}', 'Pharma\PurchaseController@restore');
    Route::post('void/{slug}', 'Pharma\PurchaseController@void');
    Route::get('voided', 'Pharma\PurchaseController@voided');
    Route::get('invoice/pos/{invoiceNumber}','Pharma\PurchaseController@printPurchaseInvoicePos');
    Route::get('invoice/a4/{invoiceNumber}','Pharma\PurchaseController@printPurchaseInvoiceA4');

});
Route::resource('purchase', 'Pharma\PurchaseController');


Route::group(['prefix' => 'sale'], function () {
    Route::post('restore/{slug}', 'Pharma\SaleController@restore');
    Route::post('void/{slug}', 'Pharma\SaleController@void');
    Route::get('voided', 'Pharma\SaleController@voided');
    Route::get('invoice/{invoiceNumber}', 'Pharma\SaleController@printSaleInvoice');
    Route::get('/products/{batch_number}', 'Pharma\SaleController@findProduct');
    Route::get('invoice/pos/{invoiceNumber}','Pharma\SaleController@printSaleInvoicePos');
    Route::get('invoice/a4/{invoiceNumber}','Pharma\SaleController@printSaleInvoiceA4');
});
Route::resource('sale', 'Pharma\SaleController');



Route::group(['prefix' => 'reports'], function () {
    Route::get('diagnostic-today', 'ReportController@diagon_today');
    Route::get('hospital-today', 'ReportController@hodpital_today');
    Route::get('admin-today','ReportController@admin_today');
    Route::get('admin-transaction','ReportController@user_trans');
    Route::get('sales', 'ReportController@sales');
    Route::get('sales-return', 'ReportController@salesReturn');
    Route::get('today', 'ReportController@today');
    Route::get('income-statement', 'ReportController@incomeStatement');
    Route::get('cash-flow', 'ReportController@cashFlow');
    Route::get('purchase', 'ReportController@purchase');
    Route::get('purchase-return', 'ReportController@purchaseReturn');
    Route::get('expense', 'ReportController@expense');
    Route::get('payment', 'ReportController@payment');
    Route::get('received', 'ReportController@received');
    Route::get('p&l/salewise', 'ReportController@profit_Loss_saleWise');
    Route::get('p&l/itemwise', 'ReportController@profit_Loss_itemWise');
    Route::get('delivary-test', 'ReportController@todayDelivaryReport');
    Route::get('admission-report', 'ReportController@todayAdmissionReport');
});


Route::get('batch/delete/{id}', 'Pharma\BatchController@delete');
Route::get('batch/product/{id}', 'Pharma\BatchController@getBatchProduct');
Route::get('batch/saggestion/{key}', 'Pharma\BatchController@batchSaggestion');
Route::resource('batch', 'Pharma\BatchController');


Route::group(['prefix' => 'stocks'], function () {
    Route::get('lowstock', 'Pharma\StockController@lowstock');
    Route::get('expiry', 'Pharma\StockController@expiry');
    Route::get('closing', 'Pharma\StockController@closingStock');
    Route::get('batch', 'Pharma\StockController@batchStock');
    Route::get('batch/refresh', 'Pharma\StockController@batchStockRefresh');
});

Route::group(['prefix' => 'taxes'], function () {
    Route::get('/', 'Pharma\taxController@index');
    Route::get('payment', 'Pharma\taxController@payment');
});