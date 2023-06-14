<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

// department
Route::get('/departments', 'departmentController@getDepartment');
Route::post('/create_department', 'departmentController@createDepartment');
Route::post('/edit_department', 'departmentController@editDepartment');
Route::delete('/delete_department', 'departmentController@deleteDepartment');

// suppliers
Route::get('/suppliers', 'supplierController@getSupplier');
Route::post('/create_supplier', 'supplierController@createSupplier');
Route::post('/edit_supplier', 'supplierController@editSupplier');
Route::delete('/delete_supplier', 'supplierController@deleteSupplier');


// purchase_orders
Route::get('/purchase_orders', 'purchaseOrderController@getPurchaseOrder');
Route::post('/create_purchase_order', 'purchaseOrderController@createPurchaseOrder');
Route::post('/edit_purchase_order', 'purchaseOrderController@editPurchaseOrder');
Route::delete('/delete_purchase_order', 'purchaseOrderController@deletePurchaseOrder');
Route::post('/mark_as_delivered', 'deliveredStockController@createDeliveredStock');

// delivered_stocks
Route::get('/delivered_stocks', 'deliveredStockController@getDeliveredStock');
Route::post('/create_delivered_stock', 'deliveredStockController@createDeliveredStock');
Route::post('/edit_delivered_stock', 'deliveredStockController@editDeliveredStock');
Route::delete('/delete_delivered_stock', 'deliveredStockController@deleteDeliveredStock');

// bad_orders
Route::get('/bad_orders', 'badOrderController@getBadOrder');
Route::post('/save_bad_order', 'badOrderController@createBadOrder');



// category
Route::get('/categories', 'categoryController@getCategory');
Route::post('/create_category', 'categoryController@createCategory');
Route::post('/edit_category', 'categoryController@editCategory');
Route::get('/category_departments', 'categoryController@getCategoryDepartment');
Route::delete('/delete_category', 'categoryController@deleteCategory');

// brand
Route::get('/brands', 'brandController@getBrand');
Route::post('/create_brand', 'brandController@createBrand');
Route::post('/edit_brand', 'brandController@editBrand');
Route::get('/brand_categories', 'brandController@getBrandCategory');
Route::delete('/delete_brand', 'brandController@deleteBrand');

// item
Route::get('/items', 'itemController@getItem');
Route::post('/create_item', 'itemController@createItem');
Route::post('/edit_item', 'itemController@editItem');
Route::get('/item_categories', 'itemController@getItemCategory');
Route::delete('/delete_item', 'itemController@deleteItem');

//customer orders
Route::get('/customer_order', 'tableController@getTable');
Route::post('/create_table', 'tableController@createTable');
Route::post('/edit_table', 'tableController@editTable');
// Route::delete('/delete_table, 'tableController@deleteTable');

//device
Route::get('/devices', 'deviceController@getDevice');
Route::post('/create_device', 'deviceController@createDevice');
Route::post('/edit_device', 'deviceController@editDevice');
Route::get('/device_departments', 'deviceController@getDeviceDepartment');
Route::delete('/delete_device', 'deviceController@deleteDevice');

//dashboard
Route::get('/dashboard_categories', 'dashboardController@getDashboardCategory');
Route::get('/dashboard_items', 'dashboardController@getDashboardItem');
Route::get('/dashboard_tables', 'dashboardController@getDashboardTable');
Route::post('/create_order', 'dashboardController@createOrder');
Route::get('/checkIfHasExistingOrder', 'dashboardController@checkIfHasExistingOrder');
Route::get('/dashboard_all_orders', 'dashboardController@getDashboardAllOrder');
Route::get('/dashboard_all_orders_this_day', 'dashboardController@getDashboardAllOrderThisDay');
Route::get('/dashboard_all_tables_this_day', 'dashboardController@getDashboardAllTableThisDay');
Route::get('/dashboard_all_tables', 'dashboardController@getDashboardAllTable');
Route::get('/total_all/{transactionId}', 'dashboardController@getTotal');
Route::get('/dashboard_all_users', 'dashboardController@getDashboardAllUsers');
Route::get('/dashboard_all_users', 'dashboardController@getDashboardAllUsers');

//customer orders
Route::get('/transactions', 'transactionsController@getTransactions');


//outsourced dashboard
Route::get('/dashboard_outsourced_all', 'outsourcedDashboardController@getDashboardOutsourcedAll');
Route::get('/dashboard_outsourced_pending', 'outsourcedDashboardController@getDashboardOutsourcedPending');
Route::get('/dashboard_outsourced_success', 'outsourcedDashboardController@getDashboardOutsourcedSuccess');
Route::get('/dashboard_outsourced_processing', 'outsourcedDashboardController@getDashboardOutsourcedProcessing');
Route::get('/dashboard_outsourced_tables', 'outsourcedDashboardController@getDashboardOutsourcedTable');
Route::post('/print_update_outsourced_processing/{transactionId}', 'outsourcedDashboardController@editPendingOrderStatus');



//print
Route::get('/print_kitchen_click/{transactionId}', 'printController@printClickKitchen');
Route::get('/print_bar_click/{transactionId}', 'printController@printClickBar');
Route::get('/print_outsourced_click/{transactionId}', 'printController@printClickOutsourced');


Route::get('/print_kitchen/{transactionId}', 'printController@printKitchen');
Route::get('/print_bar/{transactionId}', 'printController@printBar');
Route::get('/print_outsourced/{transactionId}', 'printController@printOutsourced');
Route::get('/print_receipt/{transactionId}', 'printController@printReceipt');


Route::get('/print_orders_in_transaction/{transactionId}', 'printController@getOrderInTransaction');
Route::get('/print_orders_in_transaction_details/{transactionId}', 'printController@getOrderInTransactionDetails');

Route::post('/print_all', 'printController@printReceipt');
Route::post('/print_shift_report', 'printController@printShiftReport');
Route::get('/test_print_shift_report', 'printController@testShift');
Route::post('/print_shift_report_test2', 'printController@testShiftReport');
Route::post('/print_shift_report_all', 'printController@allShiftReport'); // based on testShiftReport 
Route::post('/print_ar_all', 'printController@printARReceipt');

//User
Route::post('/create_user', 'UserController@createUser');
Route::get('/users', 'UserController@getUsers');
Route::post('/edit_user', 'UserController@editUser');
Route::get('/get_all_users', 'UserController@getAllUsers');
Route::delete('/delete_user', 'UserController@deleteUser');

//Role
Route::post('/create_role', 'UserController@addRole');
Route::post('/edit_role', 'UserController@editRole');
Route::delete('/delete_role', 'UserController@deleteRole');
Route::get('/roles', 'UserController@getRoles');
Route::get('/roles_pagination', 'UserController@getRolesPagination');
Route::post('assign_roles', 'UserController@assignRole');

// item inventory
Route::post('/add_new_batch', 'itemController@addItemInventory');
Route::get('/get_item_inventory/{itemId}', 'itemController@getItemInventory');
Route::post('/edit_batch', 'itemController@editItemInventory');
Route::get('/get_inventory_records', 'itemController@getInventoryRecords');

// reports
Route::get('/get_sales/{date1}/{date2}', 'reportsController@getSales');
Route::get('/get_bestseller_items/{date1}/{date2}', 'reportsController@getBestsellerItems');
Route::get('/get_leastseller_items/{date1}/{date2}', 'reportsController@getLeastsellerItems');
Route::get('/get_expiring_items', 'reportsController@getExpiringItems');
Route::get('/get_recent_order', 'reportsController@getRecentOrders');

//cash in
Route::post('/add_cashin', 'cashinController@addCashIn');
Route::get('/cashins', 'cashinController@getCashIn');
Route::post('/edit_cashin', 'cashinController@editCashIn');
Route::get('/print_cashin_click/{cashinId}', 'printController@printCashIn');
Route::post('/print_cashin', 'printController@printCashInSave');

//cash out
Route::post('/add_cashout', 'cashoutController@addCashOut');
Route::get('/cashouts', 'cashoutController@getCashOut');
Route::post('/edit_cashout', 'cashoutController@editCashOut');
Route::get('/print_cashout_click/{cashOutId}', 'printController@printCashOut');
Route::post('/print_cashout', 'printController@printCashOutSave');

// get user permissions
Route::get('/get_permissions', 'dashboardController@getUserPermissions');

// begining fund

Route::get('/check_beginingfund', 'beginingfundController@checkBeginingFund');
Route::post('/create_beginingfund', 'beginingfundController@createBeginingFund');

// account expense
Route::get('/account_expense', 'accountexpenseController@getAccountExpense');
Route::post('/create_account_expense', 'accountexpenseController@createAccountExpense');
Route::post('/edit_account_expense', 'accountexpenseController@editAccountExpense');

// expenses
Route::get('/get_expenses', 'expenseController@getExpenses');
Route::post('/add_expense', 'expenseController@addExpense');
Route::get('/get_expense/{id}', 'expenseController@getExpense');
Route::post('/update_expense', 'expenseController@updateExpense');
Route::get('/expense_summary/{date1}/{date2}/{preparedBy}/{reviewedBy}', 'expenseController@expenseSummary');

// raw Stocks
Route::post('/save_raw_mat', 'rawMatsController@saveRawStock');
Route::get('/fetch_raw_mats', 'rawMatsController@getRawMats');
Route::post('/save_raw_mat_batch', 'rawMatsController@saveRawMatBatch');
Route::get('/fetch_raw_mat_inv/{id}', 'rawMatsController@getRawMatInventory');

//pullout
Route::post('/pullout_item', 'itemController@pulloutItem');

//remove order

Route::post('/remove_order/{orderId}', 'dashboardController@removeOrder');

Route::get('/inventory_report/{date1}/{date2}', 'reportsController@dailyIngrCount');
Route::post('/payments/billout', 'printController@printBillout');