<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

// Home section
Route::get('/', 'Pages\HomeController@index')->name('home');

// Features section
Route::get('/features', 'Pages\FeaturesController@index')->name('features');

// Pricing section
Route::get('/pricing', 'Pages\PricingController@index')->name('pricing');
Route::get('/pricing/{plan}', 'Pages\PricingController@show')->name('plans.show');
Route::post('/subscription', 'SubscriptionController@processSubscription')->name('subscription.create');

// FAQ section
Route::get('/faq', 'Pages\FAQController@index')->name('faq');

// Team section
Route::get('/team', 'Pages\TeamController@index')->name('team');

// Contacts sections
Route::get('/contacts', 'Pages\ContactController@index')->name('contacts');
Route::post('/contacts/create', 'Pages\ContactController@store')->name('contacts.create');

/*
|--------------------------------------------------------------------------
| Adminlte
|--------------------------------------------------------------------------
*/

$adminSide = 'admin|member|developer|maintainer';
$userAdminSide = 'userFree|userPro|userWebmaster';

// Role - Admin
Route::middleware(['role:' . $adminSide])->group( function()
{

    // Dashboard section
    Route::get('/admin/dashboard', 'Adminlte\admin\DashboardAdminController@index');

    // Users sections
    Route::get('/admin/users', 'Adminlte\admin\UsersAdminController@index');

    // Profile section
    Route::get('/admin/users/{id}', 'Adminlte\admin\ProfileAdminController@index');
    Route::get('/admin/team/members/{id}', 'Adminlte\admin\ProfileAdminController@index');

    // Team Members sections
    Route::get('/admin/team/members', 'Adminlte\admin\team\MembersController@index');

    Route::get('/admin/roles', ['as' => 'admin.roles.index', 'uses' => 'Adminlte\admin\team\privileges\roles\RoleController@index']);
    Route::get('/admin/roles/create', ['as' => 'admin.roles.create', 'uses' => 'Adminlte\admin\team\privileges\roles\RoleController@create']);
    Route::post('/admin/roles', ['as' => 'admin.roles.store', 'uses' => 'Adminlte\admin\team\privileges\roles\RoleController@store']);
    Route::get('/admin/roles/{role}', ['as' => 'admin.roles.show', 'uses' => 'Adminlte\admin\team\privileges\roles\RoleController@show']);
    Route::get('/admin/roles/{role}/edit', ['as' => 'admin.roles.edit', 'uses' => 'Adminlte\admin\team\privileges\roles\RoleController@edit']);
    Route::patch('/admin/roles/{role}', ['as' => 'admin.roles.update', 'uses' => 'Adminlte\admin\team\privileges\roles\RoleController@update']);
    Route::delete('/admin/roles/{role}', ['as' => 'admin.roles.destroy', 'uses' => 'Adminlte\admin\team\privileges\roles\RoleController@destroy']);

    Route::get('/admin/assign-role', 'Adminlte\admin\team\privileges\roles\RoleAssignmentController@index');
    Route::post('/admin/assign-role', ['as' => 'admin.assign-role.store', 'uses' => 'Adminlte\admin\team\privileges\roles\RoleAssignmentController@store']);
    Route::get('/admin/add-permission', 'Adminlte\admin\team\privileges\permissions\PermissionController@index');
    Route::post('/admin/add-permission', 'Adminlte\admin\team\privileges\permissions\PermissionController@store');
    Route::get('/admin/assign-permission', 'Adminlte\admin\team\privileges\permissions\PermissionAssignmentController@index');
    Route::post('/admin/assign-permission', 'Adminlte\admin\team\privileges\permissions\PermissionAssignmentController@store');

    // Tickets section
    Route::get('/admin/tickets', 'TicketController@index');
    Route::get('/admin/tickets/{id}', 'TicketController@show');
    Route::delete('/admin/tickets/{id}', ['as' => 'admin.tickets.destroy', 'uses' => 'TicketController@destroy']);
    Route::post('/admin/tickets/close_ticket/{id}', ['as' => 'admin.tickets.close', 'uses' => 'TicketController@close']);
    Route::post('/admin/tickets/{ticket_id}/comment', 'CommentsController@postComment');

    // Settings section
    Route::get('/admin/settings', 'Adminlte\admin\SettingsAdminController@show');
    Route::patch('/admin/settings/personal_info/{id}', ['as' => 'admin.settings.personal_info.update', 'uses' => 'Adminlte\admin\SettingsAdminController@personal_info_update']);
    Route::patch('/admin/settings/notification/{id}', ['as' => 'admin.settings.notification.update', 'uses' => 'Adminlte\admin\SettingsAdminController@notification_update']);
    Route::patch('/admin/settings/password_security/{id}', ['as' => 'admin.settings.password_security.update', 'uses' => 'Adminlte\admin\SettingsAdminController@password_security_update']);
    Route::post('/admin/settings/profile_image/update', 'Adminlte\admin\SettingsAdminController@updateProfile');

    // This link will add session of language when they click to change language
    Route::get('admin/lang/{locale}', 'LocalizationController@index');
});

// Role - User Admin (free)
Route::middleware(['role:' . $userAdminSide])->group( function()
{
    // Dashboard section
    Route::get('/user/dashboard', 'Adminlte\ZabbixController@index')->name('admin.user_admin.index');
    Route::post('/user/dashboard/newAreaChartStore', 'Adminlte\ZabbixController@newAreaChartStore')->name('user.dashboard.newAreaChartStore');
    Route::post('/user/dashboard/lastStatusGet', 'Adminlte\ZabbixController@lastStatusHistoryGet')->name('user.dashboard.lastStatusHistoryGet');
    Route::post('/user/dashboard/removeItem', 'Adminlte\ZabbixController@itemRemove')->name('user.dashboard.itemRemove');
    Route::post('/user/dashboard/saveElementsPositions', 'Adminlte\ZabbixController@saveElementsPositions')->name('user.dashboard.savePosition');
    Route::post('/user/dashboard/storeGroupMemberElement', 'Adminlte\ZabbixController@storeGroupMemberElement')->name('user.dashboard.storeGroupMemberElement');

    // Monitoring sections
    Route::get('/user/monitoring/monitors/add', 'Adminlte\user_admin\monitoring\monitors\MonitoringMonitorsController@create')->name('monitor.add');
    Route::post('/user/monitoring/monitors/add', 'Adminlte\user_admin\monitoring\monitors\MonitoringMonitorsController@store')->name('add.store');
    Route::get('/user/monitoring/monitors/edit/{id}', 'Adminlte\user_admin\monitoring\monitors\MonitorEditController@show')->name('monitor.edit');
    Route::post('/user/monitoring/monitors/edit', 'Adminlte\user_admin\monitoring\monitors\MonitorEditController@update')->name('monitor.edit.update');
    Route::get('/user/monitoring/monitors/list', 'Adminlte\user_admin\monitoring\monitors\MonitoringMonitorsListController@index')->name('monitor.list.show');
    Route::post('/user/monitoring/monitors/list/delete/{monitorId}', 'Adminlte\user_admin\monitoring\monitors\MonitoringMonitorsListController@deleteMonitor')->name('monitor.destroy');
    Route::post('/user/monitoring/monitors/list/change-status/{monitorId}', 'Adminlte\user_admin\monitoring\monitors\MonitoringMonitorsListController@changeStatus')->name('monitor.changeStatus');
    Route::get('/user/monitoring/uptime', 'Adminlte\user_admin\monitoring\MonitoringUptimeController@index');
    Route::post('/user/monitoring/uptime', 'Adminlte\user_admin\monitoring\MonitoringUptimeController@store');
    Route::get('/user/monitoring/page-speed', 'Adminlte\user_admin\monitoring\MonitoringPageSpeedController@index');
    Route::post('/user/monitoring/page-speed', 'Adminlte\user_admin\monitoring\MonitoringPageSpeedController@store');
    Route::get('/user/monitoring/download-speed', 'Adminlte\user_admin\monitoring\MonitoringDownloadSpeedController@index');
    Route::post('/user/monitoring/download-speed', 'Adminlte\user_admin\monitoring\MonitoringDownloadSpeedController@store');
    
    // User group sections
    Route::get('/user/user_group', 'Adminlte\user_admin\UserGroupController@show')->name('userGroup.show');
    Route::post('/user/group/change/{groupid}', 'Adminlte\user_admin\UserGroupController@changeGroup')->name('userGroup.changeGroup');
    
    // User group control sections
    Route::get('/user/group/members/{groupid}', 'Adminlte\user_admin\GroupMemberController@show')->name('userGroup.controlGroupMembers');
    Route::post('/user/group/usersFind', 'Adminlte\user_admin\GroupMemberController@findUsers')->name('userGroup.findUsers');
    Route::post('/user/group/usersInvite', 'Adminlte\user_admin\GroupMemberController@inviteUser')->name('userGroup.inviteUser');

    //Notifications
    Route::post('/user/notifications', 'NotificationController@getNotifications')->name('notifications.getNotifications');
    Route::post('/user/notifications/decline', 'NotificationController@decline')->name('invitation.decline');
    Route::post('/user/notifications/accept', 'NotificationController@accept')->name('invitation.accept');
    Route::post('/user/notifications/remove', 'NotificationController@removeRequest')->name('invitation.removeRequest');

    // Alerts sections
    Route::get('/user/alerts', 'Adminlte\user_admin\AlertsController@index');

    // Profile section
    Route::get('/user/profile/{id}', 'Adminlte\user_admin\UserProfileController@index')->name('userProfile.show');

    // Settings section
    Route::get('/user/settings', 'Adminlte\user_admin\SettingController@index')->name('user.settings');
    Route::post('/user/settings/alert_notification', 'Adminlte\user_admin\SettingController@alertNotificationUpdate')->name('user.settings.alert_notification.update');
    Route::patch('/user/settings/personal_info/{id}', ['as' => 'user.settings.personal_info.update', 'uses' => 'Adminlte\user_admin\SettingController@personal_info_update']);
    Route::patch('/user/settings/notification/{id}', ['as' => 'user.settings.notification.update', 'uses' => 'Adminlte\user_admin\SettingController@notification_update']);
    Route::patch('/user/settings/password_security/{id}', ['as' => 'user.settings.password_security.update', 'uses' => 'Adminlte\user_admin\SettingController@password_security_update']);
    Route::post('/user/settings/profile_image/update', 'Adminlte\user_admin\SettingController@updateProfile');

    Route::get('/user/settings/subscription/plans', ['as' => 'user.settings.subscription.plans', 'uses' => 'SubscriptionController@showPlans']);
    Route::get('/user/settings/subscription/plans/cancel', ['as' => 'user.settings.subscription.plans.cancel', 'uses' => 'SubscriptionController@showConfirmation']);
    Route::get('/user/settings/subscription/plans/cancel_confirm', ['as' => 'user.settings.subscription.plans.cancel_confirm', 'uses' => 'SubscriptionController@showConfirmation']);
    Route::get('/user/settings/subscription/plans/cancel', ['as' => 'user.settings.subscription.plans.cancel', 'uses' => 'SubscriptionController@cancelSubscription']);

    // Tickets section
    Route::get('/user/support/tickets', ['as' => 'user.support.tickets', 'uses' => 'TicketController@userTickets']);
    Route::get('/user/support/tickets/create', ['as' => 'user.support.tickets.create', 'uses' => 'TicketController@userCreateTicket']);
    Route::post('/user/support/tickets/create', ['as' => 'user.support.tickets.create', 'uses' => 'TicketController@userStoreTicket']);
    Route::get('/user/support/tickets/{ticket_id}', ['as' => 'user.support.ticket', 'uses' => 'TicketController@userShowTicket']);
    Route::post('/user/support/tickets/close_ticket/{id}', ['as' => 'user.support.ticket.close', 'uses' => 'TicketController@close']);
    Route::delete('/user/support/tickets/{id}', ['as' => 'user.support.ticket.destroy', 'uses' => 'TicketController@destroy']);
    Route::post('/user/support/tickets/{ticket_id}/comment', 'CommentsController@postComment');

    // This link will add session of language when they click to change language
    Route::get('user/lang/{locale}', 'LocalizationController@index');
});

// This link will add session of language when they click to change language
Route::get('lang/{locale}', 'LocalizationController@index');

Route::get('/invoice/{invoice}', 'InvoiceController@show')->name('invoice.download');
