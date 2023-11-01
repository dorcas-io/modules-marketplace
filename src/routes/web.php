<?php

Route::group(['namespace' => 'Dorcas\ModulesMarketplace\Http\Controllers', 'middleware' => ['web','auth'], 'prefix' => 'mmp'], function() {
    Route::get('/marketplace-main', 'ModulesMarketplaceController@index')->name('marketplace-main');
    Route::get('/marketplace-services', 'ModulesMarketplaceController@marketplace')->name('marketplace-services');
    Route::get('/marketplace-products', 'ModulesMarketplaceController@marketplaceVendors')->name('marketplace-products');
    Route::get('/marketplace-contacts-main', 'ModulesMarketplaceController@contacts')->name('marketplace-contacts-main');
    Route::get('/marketplace-search', 'ModulesMarketplaceController@search')->name('marketplace-search');
    Route::get('/marketplace-contacts', 'ModulesMarketplaceController@vendorContacts')->name('marketplace-contacts');
    Route::delete('/marketplace-contacts/{id}', 'ModulesMarketplaceController@removeContact');
    Route::get('/marketplace-services/{id}', 'ModulesMarketplaceController@service');
    Route::post('marketplace-services/{id}', 'ModulesMarketplaceController@serviceRequest');
});


Route::group(['namespace' => 'Dorcas\ModulesMarketplace\Http\Controllers' ,'middleware' => ['web'],], function() {
    Route::get('/', 'ModulesMarketplaceStore@storeIndex')->name('marketplace');
    Route::get('add-to-cart/{product_id}', 'ModulesMarketplaceStore@addToCart')->name('add-to-cart');
    Route::get('checkout', 'ModulesMarketplaceStore@checkout')->name('checkout');
    Route::get('cart', 'ModulesMarketplaceStore@viewCart')->name('view-cart');
    Route::get('checkout', 'ModulesMarketplaceStore@checkout')->name('checkout');
    Route::get('get-address',  'ModulesMarketplaceStore@getAddress')->name('get-address');
    Route::get('calculate-delivery',  'ModulesMarketplaceStore@getDelivery')->name('get-delivery');
    Route::get('fetch-user-data',  'ModulesMarketplaceStore@fetchUserData')->name('fetch-user-data');
    Route::post('delivery-details','ModulesMarketplaceStore@calculateDelivery')->name('calculate-delivery');
    Route::post('get-delivery-cost','ModulesMarketplaceStore@getDeliveryCost')->name('get-delivery-cost');

    Route::get('/initialize-payment', 'ModulesMarketplaceStore@initialize')->name('initialize-pay');

    Route::get('/payment-callback', 'ModulesMarketplaceStore@callback')->name('payment-callback');


});



/*Route::group(['middleware' => ['auth'], 'namespace' => 'Directory', 'prefix' => 'directory'], function () {
    
    
    Route::get('/vendors', 'Directory@searchVendors')->name('directory.vendors');
    Route::get('/vendors/profile', 'Profile@vendorsIndex')->name('directory.vendors.profile')->middleware('vendor_only');
    Route::post('/vendors/profile', 'Profile@vendorsPost')->middleware('vendor_only');
    
    Route::get('/vendors/{id}', 'PayVendor@index')->name('directory.vendors.pay');
    
    Route::get('/{id}', 'Service@index')->name('directory.service');
    Route::post('/{id}', 'Service@request');
});*/


?>