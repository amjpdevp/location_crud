<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

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

Route::get('/', function () {
    return redirect()->route('login');
}); 


Route::view('/login','pages.login')->middleware('alreadylogin')->name('login'); // Login View Route & Middleware For check User already login or not
Route::post('/login',[UserController::class,'check'])->name('login.auth');      // Login Existing User
Route::post('/register',[UserController::class,'store'])->name('user.store');   // Register New User
Route::get('/logout',[UserController::class,'logout'])->name('logout');         // logout


//Middlware For Auth User
Route::middleware('loginaccess')->group(function () { 

/*
|--------------------------------------------------------------------------
| Route For User Dahsboard & CRUD
|--------------------------------------------------------------------------
*/

    Route::get('/dashboard',[UserController::class,'dashboard'])->name('dashboard'); // Admin User Dashbaord with CRUD

    Route::get('user/edit/{id}',[UserController::class,'edit'])->middleware('permission')->name('user.edit'); // Form For User Edit

    Route::put('user/update/{id}',[UserController::class,'update'])->name('user.update'); // Edit Request by Form
    
    Route::delete('user/delete',[UserController::class,'delete'])->middleware('permission')->name('user.delete'); // Delete Request from Ajax
/*
|--------------------------------------------------------------------------
| Route For Business CRUD Operations
|--------------------------------------------------------------------------
*/


Route::get('/businesses',[BusinessController::class,'index'])->name('business.index'); // Show Data 

Route::delete('deletebusiness',[BusinessController::class,'delete'])->middleware('permission')->name('business.delete'); // Delete By Ajax

Route::get('business/edit/{id}',[BusinessController::class,'edit'])->middleware('permission')->name('business.edit'); // Form For Data Update 

Route::put('business/update/{id}',[BusinessController::class,'update'])->name('business.update'); // Update Request

Route::post('business/register',[BusinessController::class,'store'])->name('business.store'); // New Business data Store request

Route::get('business/{id}/locations/',[BusinessController::class,'view'])->name('business.location.view'); // View List of Location Perticular Business
/*
|--------------------------------------------------------------------------
| Route For Location CRUD Operations
|--------------------------------------------------------------------------
*/

Route::get('/locations',[LocationController::class,'index'])->name('location.index'); // Show Location in table (return view)

Route::post('/location/store',[LocationController::class,'store'])->name('location.store'); // New Location Add Request

Route::get('/location/edit/{id}',[LocationController::class,'edit'])->middleware('permission')->name('location.edit'); // Data Edit form with data

Route::put('/location/update/{id}',[LocationController::class,'update'])->name('location.update'); // Data update request

Route::delete('/location/delete',[LocationController::class,'delete'])->middleware('permission')->name('business.delete'); //delete Request by AJAX

}); // Middleware->loginaccess End ;


