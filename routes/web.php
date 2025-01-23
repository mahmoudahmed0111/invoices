<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\InvoicesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('invoices','InvoicesController');

Route::resource('sections','SectionsController');

Route::resource('products','ProductsController');

Route::resource('InvoiceAttachments','InvoiceAttachmentsController');


Route::get('/section/{id}','InvoicesController@getproducts');

Route::get('/InvoicesDetails/{id}','InvoicesDetailsController@edit');

Route::get('View_file/{invoice_number}/{file_name}','InvoicesDetailsController@open_file');

Route::get('download/{invoice_number}/{file_name}','InvoicesDetailsController@get_file');

Route::post('delete_file','InvoicesDetailsController@destroy')->name('delete_file');

Route::get('edit_invoice/{id}','InvoicesController@edit');

Route::get('/Status_show/{id}', 'InvoicesController@show')->name('Status_show');

Route::post('/Status_Update/{id}', 'InvoicesController@Status_Update')->name('Status_Update');

Route::get('Invoice_Paid','InvoicesController@Invoice_Paid');

Route::get('Invoice_Unpaid','InvoicesController@Invoice_Unpaid');

Route::get('Invoice_Partial','InvoicesController@Invoice_Partial');

Route::resource('Archive', 'InvoiceArchiveController');

Route::get('Print_invoice/{id}','InvoicesController@Print_invoice');

Route::get('invoices_report','Invoices_Report@index');


Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles','RoleController');
    Route::resource('users','UserController');

    });

Route::post('Search_invoices','Invoices_Report@Search_invoices');

Route::get('customers_report', 'Customers_Report@index')->name("customers_report");

Route::post('Search_customers', 'Customers_Report@Search_customers');

Route::get('/{page}', 'AdminController@index');

Route::get('/opt', function () {
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');
    return back();
})->name('refresh');
