<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    TestController
};
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterDataController;
// use App\Http\Controllers\MDMController;
use App\Http\Controllers\SSOManagementController;
// use App\Http\Controllers\WebManagementController;
use App\Http\Controllers\API\AccessController;
use App\Livewire\AppManagement\Mobile\Mobile;
use App\Livewire\AppManagement\Web;
use App\Livewire\AppManagement\WebCreate;
use App\Livewire\Home;

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


Route::group(['middleware' => ['session_key']],function(){


    Route::get('lobby', [AccessController::class, 'lobby'])->name('lobby');
    Route::get('/dashboard', Home::class)->name('home');
    Route::post('logout', [AccessController::class, 'logout'])->name('logout');

    // #App Management - APK
    Route::get('/sso-management-apk', [SSOManagementController::class, 'apk_show'])->name('apk.index');
    Route::get('/sso-management-apk/get-data', [SSOManagementController::class, 'apk_get_data'])->name('apk.get_data');
    Route::post('/sso-management-apk/store', [SSOManagementController::class, 'apk_store'])->name('apk.store');
    Route::get('/sso-management-apk/edit', [SSOManagementController::class, 'apk_edit'])->name('apk.edit');
    Route::post('/sso-management-apk/update', [SSOManagementController::class, 'apk_update'])->name('apk.update');
    Route::get('/sso-management-apk/get-count', [SSOManagementController::class, 'apk_get_count'])->name('apk.get_count');

    #SSO MANAGEMENT - Modules
    Route::get('/sso-management-modules', [SSOManagementController::class, 'modules_show'])->name('modules.index');
    Route::get('/sso-management-modules/get-data', [SSOManagementController::class, 'modules_get_data'])->name('modules.get_data');
    Route::post('/sso-management-modules/store', [SSOManagementController::class, 'modules_store'])->name('modules.store');
    Route::get('/sso-management-modules/edit', [SSOManagementController::class, 'modules_edit'])->name('modules.edit');
    Route::post('/sso-management-modules/update', [SSOManagementController::class, 'modules_update'])->name('modules.update');
    Route::get('/sso-management-modules/get-count', [SSOManagementController::class, 'modules_get_count'])->name('modules.get_count');

    #SSO MANAGEMENT - Roles
    Route::get('/sso-management-roles', [SSOManagementController::class, 'roles_show'])->name('roles.index');
    Route::get('/sso-management-roles/get-data', [SSOManagementController::class, 'roles_get_data'])->name('roles.get_data');
    Route::post('/sso-management-roles/store', [SSOManagementController::class, 'roles_store'])->name('roles.store');
    Route::get('/sso-management-roles/edit', [SSOManagementController::class, 'roles_edit'])->name('roles.edit');
    Route::post('/sso-management-roles/update', [SSOManagementController::class, 'roles_update'])->name('roles.update');
    Route::get('/sso-management-roles/get-count', [SSOManagementController::class, 'roles_get_count'])->name('roles.get_count');

    #SSO MANAGEMENT - Users
    Route::get('/sso-management-users', [SSOManagementController::class, 'users_show'])->name('users.index');
    Route::get('/sso-management-users/create', [SSOManagementController::class, 'users_create'])->name('users.create');
    Route::get('/sso-management-users/detail/{id}', [SSOManagementController::class, 'users_detail'])->name('users.show');
    Route::post('/sso-management-users/store', [SSOManagementController::class, 'users_store'])->name('users.store');
    Route::get('/sso-management-users/edit/{id}', [SSOManagementController::class, 'user_edit'])->name('users.edit');
    Route::post('/sso-management-users/update', [SSOManagementController::class, 'user_update'])->name('users.update');
    Route::get('/sso-management-users/get-data', [SSOManagementController::class, 'get_data'])->name('users.get_data');
    Route::get('/sso-management-users/get-roles', [SSOManagementController::class, 'get_roles'])->name('users.get_roles');
    Route::post('/sso-management-users/add-module', [SSOManagementController::class, 'update_module'])->name('users.update.module');
    Route::post('/sso-management-users/delete-module', [SSOManagementController::class, 'delete_module'])->name('users.delete.module');
    Route::post('/sso-management-users/update-password', [SSOManagementController::class, 'update_password'])->name('users.update.password');
    Route::get('/sso-management-users/get-all-data', [SSOManagementController::class, 'users_get_data'])->name('users.get_all_data');

    #Master Data - Entity
    Route::get('/master-data-entity', [MasterDataController::class, 'entity_show'])->name('entity.index');
    Route::get('/master-data-entity/get-data', [MasterDataController::class, 'entity_get_data'])->name('entity.get_data');
    Route::post('/master-data-entity/store', [MasterDataController::class, 'entity_store'])->name('entity.store');
    Route::get('/master-data-entity/edit', [MasterDataController::class, 'entity_edit'])->name('entity.edit');
    Route::post('/master-data-entity/update', [MasterDataController::class, 'entity_update'])->name('entity.update');
    Route::post('/master-data-entity/delete', [MasterDataController::class, 'delete_entity'])->name('entity.delete');
    Route::get('/master-data-entity/get-count', [MasterDataController::class, 'entity_get_count'])->name('entity.get_count');


    #Master Data - Department
    Route::get('/master-data-department', [MasterDataController::class, 'depart_show'])->name('depart.index');
    Route::get('/master-data-department/get-data', [MasterDataController::class, 'depart_get_data'])->name('depart.get_data');
    Route::post('/master-data-department/store', [MasterDataController::class, 'depart_store'])->name('depart.store');
    Route::get('/master-data-department/edit', [MasterDataController::class, 'depart_edit'])->name('depart.edit');
    Route::post('/master-data-department/update', [MasterDataController::class, 'depart_update'])->name('depart.update');
    Route::post('/master-data-department/delete', [MasterDataController::class, 'delete_depart'])->name('depart.delete');


    #Master Data - Division
    Route::get('/master-data-division', [DivisionController::class, 'index'])->name('division.index');
    Route::get('/master-data-division/get-data', [DivisionController::class, 'get_data'])->name('division.get_data');
    Route::post('/master-data-division/store', [DivisionController::class, 'store'])->name('division.store');
    Route::get('/master-data-division/edit', [DivisionController::class, 'edit'])->name('division.edit');
    Route::post('/master-data-division/update', [DivisionController::class, 'update'])->name('division.update');
    Route::post('/master-data-division/delete', [DivisionController::class, 'delete'])->name('division.delete');
    Route::get('/master-data-division/get-department', [DivisionController::class, 'get_data_department'])->name('division.get_department');

    #Master Data - Position
    Route::get('/master-data-position', [MasterDataController::class, 'position_show'])->name('position.index');
    Route::get('/master-data-position/get-data', [MasterDataController::class, 'position_get_data'])->name('position.get_data');
    Route::post('/master-data-position/store', [MasterDataController::class, 'position_store'])->name('position.store');
    Route::get('/master-data-position/edit', [MasterDataController::class, 'position_edit'])->name('position.edit');
    Route::post('/master-data-position/update', [MasterDataController::class, 'position_update'])->name('position.update');
    Route::post('/master-data-position/delete', [MasterDataController::class, 'delete_position'])->name('position.delete');

    // #Master Data Management
    // Route::get('/master-management', [MDMController::class, 'index'])->name('mdm.index');
    // Route::get('/master-management/get_data', [MDMController::class, 'get_data'])->name('mdm.get_data');
    // Route::get('/master-management/get_id', [MDMController::class, 'get_id'])->name('mdm.get_id');
    // Route::post('/master-management/store', [MDMController::class, 'store'])->name('mdm.store');
    // Route::get('/master-management/edit', [MDMController::class, 'edit'])->name('mdm.edit');
    // Route::post('/master-management/update', [MDMController::class, 'update'])->name('mdm.update');
    // Route::post('/master-management/delete', [MDMController::class, 'delete'])->name('mdm.delete');
});

