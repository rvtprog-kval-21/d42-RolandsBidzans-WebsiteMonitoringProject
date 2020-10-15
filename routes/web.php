<?php

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

Route::get('/', 'Pages\HomeController@index');
Route::get('/features', 'Pages\FeaturesController@index');
Route::get('/pricing', 'Pages\PricingController@index');
Route::get('/faq', 'Pages\FAQController@index');

Route::get('/contacts', 'Pages\ContactController@index');
Route::post('/contacts/create', 'Pages\ContactController@store');

/*
|--------------------------------------------------------------------------
| Adminlte
|--------------------------------------------------------------------------
*/
// Role - Admin
Route::group(['middleware' => ['role:admin']], function()
{
    Route::get('/admin/add-role', 'RoleController@index');
    Route::post('/admin/add-role', 'RoleController@store');

    Route::get('/admin/add-permission', 'PermissionController@index');
    Route::post('/admin/add-permission', 'PermissionController@store');
});

// Role - User Admin (free)
Route::group(['middleware' => ['role:userFree|userPro']], function()
{
    Route::get('/dashboard', 'Adminlte\ZabbixController@historyGet')->name('admin.user_admin.index');

    Route::get('/monitoring/monitors/add', 'Adminlte\MonitorController@store');
    Route::get('/monitoring/monitors/history', 'Adminlte\MonitorController@history');
    Route::get('/monitoring/uptime', 'Adminlte\MonitorController@uptime');
    Route::get('/monitoring/page-speed', 'Adminlte\MonitorController@pageSpeed');
    Route::get('/monitoring/transaction', 'Adminlte\MonitorController@transaction');
    Route::get('/monitoring/real-user-monitoring', 'Adminlte\MonitorController@realUserMonitoring');

    Route::get('/reports/uptime', 'Adminlte\ReportController@uptime');
    Route::get('/reports/page-speed', 'Adminlte\ReportController@pageSpeed');
    Route::get('/reports/transaction', 'Adminlte\ReportController@transaction');
    Route::get('/reports/real-user-monitoring', 'Adminlte\ReportController@realUserMonitoring');

    Route::get('/alerts/list', 'Adminlte\AlertController@list');
    Route::get('/alerts/on-call', 'Adminlte\AlertController@onCall');

    Route::get('/settings', 'Adminlte\SettingController@index');
    Route::get('/support', 'Adminlte\SupportController@index');
});
