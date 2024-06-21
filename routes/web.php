<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Redirect landing page without login
Route::get('/', function(){ return redirect('/purchase-source'); });

Route::get('/purchase-source', 'PurchaseController@purchaseSource')->name('purchase.source');
Route::post('/purchase-index', 'PurchaseController@index')->name('purchase.index');
Route::post('/get-dealer-report', 'PurchaseController@getDealerReport')->name('get.dealer.report');
Route::post('/purchase-submit', 'PurchaseController@submit')->name('purchase.submit');
Route::post('/query-product-details', 'PurchaseController@queryProductDetails')->name('query.product.details');
Route::post('/purchase-payment', 'PurchaseController@purchasePayment')->name('purchase.payment');
Route::get('/purchase-return', 'PurchaseController@returnPayment')->name('purchase.return');
Route::get('/purchase-message', 'PurchaseController@purchaseMessage')->name('purchase.message');

// Disabled default Laravel Auth Route. Use custom route.
// Auth::routes(['register' => false]);
Route::get('/admin-login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/admin-login-submit', 'Auth\LoginController@login')->name('login.submit');
Route::post('/admin-logout', 'Auth\LoginController@logout')->name('logout');

// Change password pages routes
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        // Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        // Route::post('password', 'ChangePasswordController@update')->name('password.update');
    }
});

// Admin panel pages routes
Route::group([
    'prefix' => 'admin-panel',
    'as' => 'admin.',
    'namespace' => 'Admin',
    'middleware' => ['auth', 'admin']
], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/manage-product', 'EcomController@manageProduct')->name('manage.product');
    Route::get('/edit-product/{pid}', 'EcomController@editProduct')->name('edit.product');
    Route::put('/update-product/{pid}', 'EcomController@updateProduct')->name('update.product');
    Route::get('/create-product', 'EcomController@createProduct')->name('create.product');
    Route::post('/store-product', 'EcomController@storeProduct')->name('store.product');

    Route::get('/manage-product-details/{pdid}', 'EcomController@manageProductDetails')->name('manage.product.details');
    Route::get('/edit-product-details/{pdid}', 'EcomController@editProductDetails')->name('edit.product.details');
    Route::put('/update-product-details/{pdid}', 'EcomController@updateProductDetails')->name('update.product.details');
    Route::get('/create-product-details/{pdid}', 'EcomController@createProductDetails')->name('create.product.details');
    Route::post('/store-product-details/{pdid}', 'EcomController@storeProductDetails')->name('store.product.details');

    Route::get('/manage-order', 'EcomController@manageOrder')->name('manage.order');
    Route::get('/manage-order-details/{oid}', 'EcomController@manageOrderDetails')->name('manage.order.details');

    Route::get('/manage-misc', 'EcomController@manageMisc')->name('manage.misc');
    Route::post('/update-misc', 'EcomController@updateMisc')->name('update.misc');

    Route::get('/export-invoice/{oid}', 'EcomController@exportInvoice')->name('export.invoice');

    Route::get('/check-stripe-tax', 'EcomController@checkStripeTax')->name('check.stripe.tax');
});
