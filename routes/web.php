<?php

use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\AssetGroupController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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

Route::group(['domain' => '{user:domain}.' . config('app.short_url'), 'as' => 'tenant.'], function () {
    Route::get('/', [App\Http\Controllers\TenantController::class, 'show'])->name('show');
});

Route::redirect('/', '/home');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/invitation/{user}', [App\Http\Controllers\TenantController::class, 'invitation'])->name('invitation');

Route::get('/password', [App\Http\Controllers\Auth\PasswordController::class, 'create'])->name('password.create');

Route::post('/password', 'Auth\PasswordController@store')->name('password.store');

// Route::group(['as' => 'admin.', 'namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth']], function () {
Route::group(['as' => 'admin.',  'prefix' => 'admin', 'middleware' => ['auth']], function () {
    // Route::group(['middleware' => ['auth']], function () {
    Route::get('tenants/{tenant}/suspend', [TenantController::class, 'suspend'])->name('tenants.suspend');

    Route::resource('tenants', TenantController::class);

    Route::resource('users', UserController::class);

    Route::resource('roles', RoleController::class);

    Route::resource('asset-groups', AssetGroupController::class);

    Route::resource('assets', AssetController::class);

    Route::post('images/media', [ImageController::class, 'storeMedia'])->name('images.storeMedia');

    Route::resource('images', ImageController::class);

    Route::post('documents/media', [DocumentController::class, 'storeMedia'])->name('documents.storeMedia');

    Route::resource('documents', DocumentController::class);

    Route::resource('notes', NoteController::class);


    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});
