<?php

Route::group(['namespace' => 'Dorcas\ModulesMarketplace\Http\Controllers', 'middleware' => ['web']], function() {
    Route::get('sales', 'ModulesMarketplaceController@index')->name('sales');
});




Route::group(['middleware' => ['auth'], 'namespace' => 'Directory', 'prefix' => 'directory'], function () {
    Route::get('/', 'Directory@search')->name('directory');
    
    Route::get('/vendors', 'Directory@searchVendors')->name('directory.vendors');
    Route::get('/vendors/profile', 'Profile@vendorsIndex')->name('directory.vendors.profile')->middleware('vendor_only');
    Route::post('/vendors/profile', 'Profile@vendorsPost')->middleware('vendor_only');
    
    Route::get('/vendors/{id}', 'PayVendor@index')->name('directory.vendors.pay');
    
    Route::get('/{id}', 'Service@index')->name('directory.service');
    Route::post('/{id}', 'Service@request');
});


?>