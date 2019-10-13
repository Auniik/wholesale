<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::middleware(['auth'])->group(function () {
    /*
     * Helper Configs
     */
    //Artisan Routes
    //    Route::get('/clear-cache', function() {
    //        $exitCode = Artisan::call('cache:clear');
    //        return redirect()->back()->with('success','Successfully Clear Cache facade value.');
    //    });
    //    Route::get('/config-cache', function() {
    //        $exitCode = Artisan::call('config:cache');
    //        return redirect('/')->withSuccess('Successfully Clear Config cache.');
    //    });

    // Manual TRUNCATE Tables
    Route::get('truncate', 'DashboardController@allTable');
    Route::get('truncate/{table}', 'DashboardController@truncateTable');

    /*
     * ############################### Dashboard ########################################
     */
    Route::get('/system-configs', 'SystemConfigController@index');
    Route::post('/system-configs/store', 'SystemConfigController@store');
	Route::get('/dashboard', 'DashboardController@dashboard');
//    Route::get('home', 'HomeController@home');
    Route::get('/', 'HomeController@index')->name('home');
	Route::get('profile','ProfileController@index')->middleware();
    Route::post('profile','ProfileController@store');
    Route::post('profile-pass','ProfileController@changePass');
    Route::get('employeeinfo/edit','ProfileController@editEmployee');
    Route::put('employeeinfo/update','ProfileController@profileUpdate');
    Route::resource('others-info','OthersInfoController')->except('create','store','edit','destroy');
    Route::resource('terms-condition', 'TermsConditionController'); // Permission Middleware added in controller

    /*
     * ############################### USER ROLE PERMISSION SECTION ########################################
     */
    Route::resource('users', 'UsersController');
    Route::put('users/{user}/updatepassword', 'UsersController@changePass');
    Route::resource('roles', 'RoleController');
    Route::get('permissions/{role}/edit', 'PermissionController@edit')->name('permissions.edit');
    Route::post('permissions/{role}/permission-change', 'PermissionController@change'); // Ajax Post


    // Companies
    Route::resource('companies', 'CompanyListController')->except('show'); // Permission Middleware added in controller

    /*
     * ############################### CRM Part ########################################
     * */

    //Parties
    Route::resource('parties', 'PartyController')->except('show'); //Permission Added into controller

//   * Ajax Party Get
    Route::get('party', 'PartyController@getByName');

//    Route::resource('crm-event','CrmEventController');
//    Route::get('crm-event-delete/{id}',['as'=>'event.delete','uses'=>'CrmEventController@destroy']);

//    Route::resource('crm-subject','CrmSubjectController');
//    Route::get('crm-subject-delete/{id}',['as'=>'crm_subject.delete','uses'=>'CrmSubjectController@destroy']);

//    Route::resource('crm-stage','CrmStageController');
//    Route::get('crm-stage-delete/{id}',['as'=>'crm_stage.delete','uses'=>'CrmStageController@destroy']);
//    Route::resource('crm-task','CrmTaskController');


    Route::resource('tasks','TaskController');

    /*
     * SMS
    */
    Route::resource('sms-group', 'SmsGroupController')->except(['create','edit']);
    Route::resource('sms-configs', 'SmsConfigController')->except(['create','edit', 'update', 'show']);
    Route::get('manage-sms','SmsController@index');
    Route::post('send-sms','SmsController@sendSms'); //Send SMS

    Route::get('get-smsable-parties','SmsController@getParties'); //Get Parties
    Route::get('get-smsable-patient-type','SmsController@getPatientType'); //Get Parties
    Route::get('get-employee','SmsController@getEmployee'); //Get data
    Route::get('get-group-numbers/{id}','SmsController@getGroupNumbers'); //Ajax
    Route::resource('sms-template','SmsTemplateController')->except('create','show','edit'); // Permission Middleware added in controller.
    Route::get('find-sms-template/{id}','SmsTemplateController@findTemplate'); // Get data

    Route::post('report-smsable-numbers','ReportSmsableNumberController@report'); // Get data


    /*
    * ############################### General Account Section ########################################
    */

//  * Chart Of Account, Bank Account, Payment Method
    Route::resource('accounts', 'AccountSettingController'); // Permission Middleware added in controller.
    Route::resource('payment-methods', 'AccountPaymentMethodController'); // Permission Middleware added in controller.
    Route::resource('chart-of-accounts', 'PaymentSectorController'); // Permission Middleware added in controller.
//  * Account Dashboard
    Route::get('accounts-dashboard','AccountDashboardController@index');
//  * Debit Voucher
    Route::resource('debit-vouchers', 'GeneralPaymentController'); // Permission middleware added in controller
    Route::get('debit-vouchers/{debit_voucher}/confirm', 'GeneralPaymentController@editConfirm')
        ->name('debit-voucher.confirm')
        ->middleware('can:confirm-debit-voucher');
    Route::put('debit-vouchers/{debit_voucher}/confirm', 'GeneralPaymentController@updateConfirm')
            ->middleware('can:confirm-debit-voucher');
    // added in
    // controller
//  * Credit Voucher
    Route::resource('credit-vouchers','GeneralIncomeController'); // Permission middleware added in controller
    //  * Advance Payment Vouchers
    Route::resource('advance-payment-vouchers', 'AdvancePaymentController');
    Route::post('advance-payment-vouchers/{voucher}/adjust', 'AdvancePaymentController@adjust'); // Permission middleware added in controller
//  * Ajax Data Load
    Route::get('getPaymentMethod', 'AccountPaymentMethodController@getMethods');
    Route::get('load-parties','PartyController@load_parties');
    Route::get('load-chart-of-accounts','PaymentSectorController@load_sector');
    Route::get('load-petty-charts','PettyCashChartsController@loadPettyCharts');
    Route::get('search-vouchers','GeneralPaymentController@searchVouchers');
    //ad
    Route::get('get-account-dashboard','AccountDashboardController@dashboard');



//  * Petty Cash
    Route::resource('petty-cash-vouchers', 'PettyCashVoucherController'); // Permission middleware added in controller
    Route::resource('petty-cash-deposits', 'PettyCashDepositController'); // Permission middleware added in controller
    Route::resource('petty-cash-charts', 'PettyCashChartsController');
//  * Voucher Due Payments
    Route::post('vouchers/{voucher}/payments', 'VoucherPaymentController@store');
    Route::get('vouchers/{voucher}/payments/create', 'VoucherPaymentController@create');
    Route::get('vouchers/{voucher}/payments', 'VoucherPaymentController@index');
    Route::get('voucher-payments/{payment}', 'VoucherPaymentController@show');
    Route::delete('voucher-payments/{payment}', 'VoucherPaymentController@destroy');
//  * Office Equipments
//    Route::resource('equipment-categories', 'Procurement\EquipmentCategoryController');
//    Route::resource('equipments', 'Procurement\EquipmentController');
//    Route::resource('equipment-purchases', 'Procurement\EquipmentPurchaseController');
//    Route::resource('equipment-distributes', 'Procurement\EquipmentDistributeController');
//    Route::get('load-office-equipments-categories', 'Procurement\EquipmentCategoryController@categories');
//    Route::get('load-office-equipments', 'Procurement\EquipmentController@getProducts');
    //  * Purchase Payment
    //  * Purchase Due Payments
//    Route::post('purchases/{purchase}/payments', 'Procurement\EquipmentPurchasePaymentController@store');
//    Route::get('purchases/{purchase}/payments/create', 'Procurement\EquipmentPurchasePaymentController@create');
//    Route::get('purchases/{purchase}/payments', 'Procurement\EquipmentPurchasePaymentController@index');
//    Route::get('purchase-payments/{payment}', 'Procurement\EquipmentPurchasePaymentController@show');
//    Route::delete('purchase-payments/{payment}', 'Procurement\EquipmentPurchasePaymentController@destroy');
    //  * installments
    Route::resource('installments', 'InstallmentController');

    /*
     * Account Reports
     * */
//    Route::get('cash-collections', 'CashCollectionController@index')->middleware('can:reports-show');

//  * Balance Transfer
    Route::resource('balance-transfers', 'BalanceTransferController'); // Permission middleware added in controller
    Route::post('balance-transfers/{balance_transfer}/approve', 'BalanceTransferController@approve')->name('balance-transfer.approve');
    Route::get('getBalance', 'BalanceTransferController@getBalance'); // Ajax Data Load



    ############################### PHARMACY MANAGEMENT ########################################
    /*
     * Inventory Settings
     * Inventory Reports
     * */

    Route::prefix('products')->group(function () {
        Route::resource('categories', 'Inventory\CategoryController');
//    Route::resource('medicine-types', 'Pharmacy\MedicineTypeController');
//    Route::resource('inventory-brands', 'Pharmacy\InventoryBrandController');
        Route::resource('manufacturers', 'Inventory\ManufacturerController');
        Route::resource('barcodes', 'Inventory\BarcodeController');
        Route::resource('codes', 'Inventory\ProductCodeController', ['as' => 'product']);

        Route::resource('purchases', 'Inventory\ProductPurchaseController', ['as' => 'product']);
        Route::resource('sales', 'Inventory\ProductSaleController', ['as' => 'product']);

    });
    Route::resource('/products', 'Inventory\ProductController');

    Route::prefix('quotations')->group(function () {
        Route::resource('challans', 'Quotation\ChallanController', ['as' => 'quotation']);
    });
    Route::resource('quotations', 'Quotation\QuotationController');


//    Route::resource('inventory-categories', 'Pharmacy\InventoryCategoryController');
//    Route::resource('medicine-types', 'Pharmacy\MedicineTypeController');
//    Route::resource('inventory-brands', 'Pharmacy\InventoryBrandController');

    Route::get('load-barcodeable-products', 'Inventory\BarcodeController@loadBarcodeableProducts');
    Route::get('load-saleable-products', 'Inventory\ProductSaleController@saleableProducts');
    Route::get('get-barcode/{product}', 'Inventory\BarcodeController@getBarcodeNumber');
    Route::get('get-purchasable-products/{id}', 'Inventory\ProductPurchaseController@purchasableProducts');
    Route::get('get_codes/{product}', 'Inventory\ProductPurchaseController@productCodes');
    Route::get('load-product', 'Inventory\ProductController@loadProduct');

//    Route::resource('inventory-units', 'Pharmacy\InventoryUnitController');
//    Route::resource('inventory-generics', 'Pharmacy\MedicineGenericController');

//    Route::resource('inventory-products', 'Pharmacy\InventoryProductController');
//    Route::resource('inventory-barcodes', 'Pharmacy\InventoryProductBarcodeController');
//    Route::resource('inventory-product-purchases', 'Pharmacy\InventoryProductPurchaseController');


    Route::delete('product-purchases/{item}', 'Pharmacy\InventoryProductPurchaseController@productDelete');

    Route::get('inventory-product-purchases/{invoice}/payments/create', 'Pharmacy\InventoryPurchasePaymentController@create')
        ->name('pharmacy-purchases.create');
    Route::get('inventory-product-purchases/{invoice}/payments', 'Pharmacy\InventoryPurchasePaymentController@index')
        ->name('pharmacy-purchases.index');
    Route::post('inventory-product-purchases/{invoice}/payments', 'Pharmacy\InventoryPurchasePaymentController@store')
        ->name('pharmacy-purchases.store');
    Route::delete('inventory-product-purchases/payments/{payment}', 'Pharmacy\InventoryPurchasePaymentController@destroy')
        ->name('pharmacy-purchases.destroy');

    Route::resource('inventory-product-sales', 'Pharmacy\InventoryProductSalesController');
    Route::get('inventory-product-sales/{invoice}/payments/create', 'Pharmacy\InventorySalePaymentController@create')
        ->name('pharmacy-sales.create');
    Route::get('inventory-product-sales/{invoice}/payments', 'Pharmacy\InventorySalePaymentController@index')
        ->name('pharmacy-sales.index');
    Route::post('inventory-product-sales/{invoice}/payments', 'Pharmacy\InventorySalePaymentController@store')
        ->name('pharmacy-sales.store');
    Route::delete('inventory-product-sales/payments/{payment}', 'Pharmacy\InventorySalePaymentController@destroy')
        ->name('pharmacy-sales.destroy');



    // Reports
    Route::prefix('reports')->middleware('can:reports-show')->group(function () {
        //Pharmacy
        Route::prefix('pharmacy')->group(function () {
            Route::get('inventory', 'Pharmacy\InventoryReportController@productWiseInventory');
            Route::get('inventory/stock-alert', 'Pharmacy\InventoryReportController@stockAlertReports');
            Route::get('sales/customer-wise', 'Pharmacy\InventoryReportController@customerWiseSales');
            Route::get('sales/product-wise', 'Pharmacy\InventoryReportController@productWiseSales');
            Route::get('purchase/product-wise', 'Pharmacy\InventoryReportController@productWisePurchase');
            Route::post('inventory', 'Pharmacy\InventoryReportController@productWiseInventory');
        });

        //Accounts
        Route::prefix('accounts')->group(function () {
//            Route::get('cash-collections', 'report\AccountsReportController@cashCollection');
//            Route::get('daily-cash-receives', 'report\AccountsReportController@dailyCashReceived');
//            Route::get('income-expense', 'report\AccountsReportController@incomeExpense');
//            Route::get('petty-cash', 'report\AccountsReportController@pettyCash');
        });

    });



});
