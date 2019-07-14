<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/billing', 'BillingController@form');
Route::post('/billing', 'BillingController@process');

Route::get('/api/{apiKey}/{sku}/{meta?}', 'APIController@sendProducts');


Auth::routes();
Route::get('/login', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth']], function () {
	//Route::get('/home', 'HomeController@index');
	Route::get('/home', 'ProductController@index');
	Route::get('/my-profile', 'ProfileController@index');
	Route::post('/updateProfile', 'ProfileController@updateProfile');
	Route::get('/change-password', 'ProfileController@changePassword');
	Route::post('/updatePassword', 'ProfileController@updatePassword');

	//Product
	Route::any('/testcsvupload', 'ProductController@testcsvupload');
	Route::any('/manage-product/{any?}', 'ProductController@index');
	Route::any('/manage-vendor-product', 'ProductController@manageVendorProduct');
	Route::any('/import-product-by-vendor', 'ProductController@importProductByVendor');
	Route::any('/import-artist', 'ProductController@importArtist');
	Route::any('/manage-artist-template', 'ProductController@importArtistTemplate');

	Route::get('/add-product', 'ProductController@create');
	Route::get('/add-product/{id}', 'ProductController@copyProduct');
	Route::post('/store-product', 'ProductController@store');    
	Route::get('/edit-product/{id}', 'ProductController@edit');
	Route::post('/product/update', 'ProductController@update');
	Route::get('/delete-product/{id}', 'ProductController@deleteRecord');
	Route::get('/delete-only-image-product/{id}/{image_name}', 'ProductController@deleteImageOnly');
	Route::post('/addVariantsGroupOptions', 'ProductController@addVariantsGroupOptions');
	Route::get('/getAllProducts', 'ProductController@getAllProducts');
	Route::get('/delete_dynamic_field/{id}', 'ProductController@delete_dynamic_field');
	Route::any('/api/v1', 'APIController@getOrderDataFromOrderDesk');
	Route::get('/create-product-thumbs', 'ProductController@productListToCreateThumb');
	Route::get('/cron-create-thumbs', 'ProductController@cronCreateThumb');
	Route::get('/index.php/cron-create-thumbs', 'ProductController@cronCreateThumb');
	Route::get('create-thumb-by-product-id', 'ProductController@createThumbByProductId');
	Route::get('/getProductsAjax', 'ProductController@getProductsAjax');
	Route::get('getDynamicFields', 'ProductController@get_dynamic_fields');
	Route::get('/getDefaultFields', 'ProductController@get_default_fields');
	Route::get('/bulk-edit', 'BulkEditController@bulkEdit');
	Route::post('/bulk-edit', 'BulkEditController@search');
	Route::post('/bulk-edit-update', 'BulkEditController@updateField');
	Route::post('/bulk-delete', 'ProductController@bulkDelete');

	Route::get('/place-order', 'ProductController@placeOrder');
	Route::get('/orderDeskProductSubmit', 'OrderDeskApiController@orderDeskProductSubmit');


	Route::any('/upload-product-image', 'ProductController@uploadProductImage');
	Route::any('/upload-secondary-image', 'ProductController@uploadSecondaryImage');
	Route::any('/upload-design-image', 'ProductController@uploadDesignImage');
	Route::any('/removePrimaryImage', 'ProductController@removePrimaryImage');
	Route::any('/removeSecondaryImage/{secondary_image_name}', 'ProductController@removeSecondaryImage');
	Route::any('/removeSecondaryImageWhileCreate/{serial}', 'ProductController@removeSecondaryImageWhileCreate');
	Route::any('/removeHireDesignImage', 'ProductController@removeHireDesignImage');
	Route::get('/upload-product-image', 'ProductController@upload_product_image');


	Route::get('downloadExcel/{type}', 'ProductController@downloadExcel');
	Route::any('importExcel', 'ProductController@importExcel');
	Route::get('/csv-import', 'ProductController@csvImport');
	Route::any('/csv-export', 'ProductController@csvExport');

	Route::get('/reports', 'ReportController@index');
	Route::post('/reports', 'ReportController@generateReport');
	Route::get('/report-builder', 'ReportController@reportBuilder');
	Route::post('/report-builder', 'ReportController@generateReportBuilder');
	Route::get('/search', 'ReportController@search');
	Route::post('/search', 'ReportController@generateReport');



	Route::get('/manage-vendor', 'VendorManageController@index');
	Route::get('/add-vendor', 'VendorManageController@create');
	Route::post('/store-vendor', 'VendorManageController@store');
	Route::get('/edit-vendor/{id}', 'VendorManageController@edit');
	Route::get('/delete-vendor/{id}', 'VendorManageController@destroy');

	Route::get('/manage-folder', 'FolderManageController@index');
	Route::get('/add-folder', 'FolderManageController@create');
	Route::post('/store-folder', 'FolderManageController@store');
	Route::get('/edit-folder/{id}', 'FolderManageController@edit');
	Route::get('/delete-folder/{id}', 'FolderManageController@destroy');

	Route::get('/manage-category', 'CategoryManageController@index');
	Route::get('/add-category', 'CategoryManageController@create');
	Route::post('/store-category', 'CategoryManageController@store');
	Route::get('/edit-category/{id}', 'CategoryManageController@edit');
	Route::get('/delete-category/{id}', 'CategoryManageController@destroy');

	Route::get('/manage-price-type', 'CustomerGroupManageController@index');
	Route::get('/add-price-type', 'CustomerGroupManageController@create');
	Route::post('/store-price-type', 'CustomerGroupManageController@store');
	Route::get('/edit-price-type/{id}', 'CustomerGroupManageController@edit');
	Route::get('/delete-price-type/{id}', 'CustomerGroupManageController@destroy');

	Route::get('/manage-tag-group', 'TagGroupManageController@index');
	Route::get('/add-tag-group', 'TagGroupManageController@create');
	Route::post('/store-tag-group', 'TagGroupManageController@store');
	Route::get('/edit-tag-group/{id}', 'TagGroupManageController@edit');
	Route::get('/delete-tag-group/{id}', 'TagGroupManageController@destroy');

	Route::get('/manage-tag', 'TagManageController@index');
	Route::get('/add-tag', 'TagManageController@create');
	Route::post('/store-tag', 'TagManageController@store');
	Route::get('/edit-tag/{id}', 'TagManageController@edit');
	Route::get('/delete-tag/{id}', 'TagManageController@destroy');

	Route::get('/manage-product-type', 'ProductTypeManageController@index');
	Route::get('/add-product-type', 'ProductTypeManageController@create');
	Route::post('/store-product-type', 'ProductTypeManageController@store');
	Route::get('/edit-product-type/{id}', 'ProductTypeManageController@edit');
	Route::get('/delete-product-type/{id}', 'ProductTypeManageController@destroy');

	Route::get('/manage-currency', 'CurrencyManageController@index');
	Route::get('/add-currency', 'CurrencyManageController@create');
	Route::post('/store-currency', 'CurrencyManageController@store');
	Route::get('/edit-currency/{id}', 'CurrencyManageController@edit');
	Route::get('/delete-currency/{id}', 'CurrencyManageController@destroy');

	Route::get('/manage-collection', 'CollectionManageController@index');
	Route::get('/add-collection', 'CollectionManageController@create');
	Route::post('/store-collection', 'CollectionManageController@store');
	Route::get('/edit-collection/{id}', 'CollectionManageController@edit');
	Route::get('/delete-collection/{id}', 'CollectionManageController@destroy');
	Route::post('/search-products', 'CollectionManageController@search');

	Route::get('/manage-description', 'DescriptionManageController@index');
	Route::get('/add-description', 'DescriptionManageController@create');
	Route::post('/store-description', 'DescriptionManageController@store');
	Route::get('/edit-description/{id}', 'DescriptionManageController@edit');
	Route::get('/delete-description/{id}', 'DescriptionManageController@destroy');

	Route::get('/manage-export-template', 'ExportTemplateManageController@index');
	Route::get('/add-export-template', 'ExportTemplateManageController@create');
	Route::post('/store-export-template', 'ExportTemplateManageController@store');
	Route::get('/edit-export-template/{id}', 'ExportTemplateManageController@edit');
	Route::get('/delete-export-template/{id}', 'ExportTemplateManageController@destroy');

	Route::get('/manage-import-template', 'ImportTemplateManageController@index');
	Route::get('/add-import-template', 'ImportTemplateManageController@create');
	Route::post('/store-import-template', 'ImportTemplateManageController@storeImportTemplate');
	Route::get('/edit-import-template/{id}', 'ImportTemplateManageController@edit');
	Route::get('/delete-import-template/{id}', 'ImportTemplateManageController@destroy');
	Route::post('/import-template', 'ImportTemplateManageController@templateImport');
	Route::get('/import-template/{id}', 'ImportTemplateManageController@viewTemplate');
	Route::get('/automated-rules/{id}', 'ImportTemplateManageController@automatedRules');
	Route::post('/automated-rules', 'ImportTemplateManageController@automatedRules');
	Route::get('/manage-vendor-template', 'ImportTemplateManageController@manageVendorTemplate');
	



	Route::get('/generate_aku_code', 'ProductController@generateAkuCode');
	Route::get('/is_valid_aku_code/{number}/{product_row_id?}', 'ProductController@isValidAkuCode');
	Route::get('/generate_aku2_code', 'ProductController@generateAku2Code');
	Route::get('/is_valid_aku2_code/{number}/{product_row_id?}', 'ProductController@isValidAku2Code');
	Route::get('/setDescriptionField/{description_row_id}', 'ProductController@setDescriptionField');

	Route::any('/manageUnit', function () {
	    return view('unit.unit_home');
	});

	Route::get('/createUnit', function () {
	    return view('unit.unit_create');
	});

	Route::any('/managePriceType', function () {
	    return view('price_type.price_type_home');
	});
	Route::get('/createPriceType', function () {
	    return view('price_type.price_type_create');
	});


	Route::get('/apikey', 'APIController@apiKey');
	Route::post('/api/product', 'APIController@provideProduct');
	Route::get('/api/product', function () {
	    die("Sorry, Your request cannot be processed, submit data in post method.");
	});

	Route::get('/manage-sales-template', 'SalesTemplateController@index');
	Route::get('/add-sales-template', 'SalesTemplateController@create');
	Route::post('/store-sales-template', 'SalesTemplateController@storeImportTemplate');
	Route::get('/edit-sales-template/{id}', 'SalesTemplateController@edit');
	Route::get('/delete-sales-template/{id}', 'SalesTemplateController@destroy');
	Route::post('/import-sales-template', 'SalesTemplateController@templateImport');
	Route::get('/import-sales-template/{id}', 'SalesTemplateController@viewTemplate');
	Route::post('importSalesExcel', 'SalesTemplateController@importSalesExcel');
	Route::post('getSalesData', 'ReportController@getSalesData');
	//Route::any('search-products', 'ReportController@searchProductAndSalesData');

	Route::get('/integrations', 'APIController@showAllIntegrations');
	Route::get('/orderdesk-integration', 'APIController@orderDeskIntegration');
	Route::get('/verify-orderdesk-details/{store_id}/{api_key}', 'APIController@verifyOrderdeskDetails');
	Route::post('/store-integration-info', 'APIController@storeOrderDeskIntegration');
});