<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userAuthController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[userAuthController::class,'index']);
Route::post('/',[userAuthController::class,'login']);
Route::get('/logout',[userAuthController::class,'logout']);

Route::group(['middleware' => 'useradmin'],function (){
    Route::get('/dashboard',[dashboardController::class,'dashboard']);
});

Route::get('/role',[RoleController::class,'list']);
Route::post('/role/update/{id}',[RoleController::class,'update'])->name('role.update');
Route::post('/role',[RoleController::class,'insert']);
Route::get('/role/edit/{id}',[RoleController::class,'edit'])->name('role.edit');
Route::get('/role/delete/{id}',[RoleController::class,'delete']);

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/role', [AdminController::class, 'index'])->name('role');
    Route::post('/admin/assign-role/{userId}', [AdminController::class, 'assignRole']);
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/create-role', [AdminController::class, 'createRole'])->name('admin.createRole');
    Route::get('/admin/edit-role-permissions/{roleId}', [AdminController::class, 'editRolePermissions'])->name('admin.editRolePermissions');
    Route::post('/admin/edit-role-permissions/{roleId}', [AdminController::class, 'updateRolePermissions'])->name('admin.updateRolePermissions');
    Route::delete('/admin/delete-role/{id}', [AdminController::class, 'deleteRole'])->name('admin.deleteRole');
    Route::post('/admin/assign-permissions/{roleId}', [AdminController::class, 'assignPermissions']);

    Route::get('/admin/create-user', [AdminController::class, 'createUserForm'])->name('admin.createUserForm');
    Route::post('/admin/create-user', [AdminController::class, 'storeUser'])->name('admin.storeUser');
    Route::get('/admin/users', [AdminController::class, 'showUsers'])->name('admin.Users');
    Route::get('/edit/user/{id}', [AdminController::class, 'editUser'])->name('admin.editUser');
    Route::get('/delete/user/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
});


