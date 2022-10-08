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


Route::view('/login','pages.login')
    ->middleware('alreadylogin')
    ->name('login');

Route::post('/login',[UserController::class,'check'])->name('login.auth');
Route::post('/register',[UserController::class,'store'])->name('user.store');

Route::middleware('loginaccess')->group(function () {

Route::get('/dashboard',function(){
    $users = User::paginate(5);
    return view('pages.user',compact('users'));
    })->name('dashboard'); //User Dashboard

Route::get('/logout',function (Request $request){
    Auth::logout();
    $request->session()->flush();
    return redirect()->route('login');
})->name('logout'); //logout


/*
|--------------------------------------------------------------------------
| Route For Business CRUD Operations
|--------------------------------------------------------------------------
*/


Route::get('/businesses',[BusinessController::class,'index'])->name('business.index'); // Show Data 

Route::delete('deletebusiness',[BusinessController::class,'delete'])->name('business.delete'); // Delete By Ajax

Route::get('business/edit/{id}',[BusinessController::class,'edit'])->name('business.edit'); // Form For Data Update 

Route::put('business/update/{id}',[BusinessController::class,'update'])->name('business.update'); // Update Request

Route::post('business/register',[BusinessController::class,'store'])->name('business.store'); // New Business data Store request


/*
|--------------------------------------------------------------------------
| Route For Location CRUD Operations
|--------------------------------------------------------------------------
*/

Route::get('/locations',[LocationController::class,'index'])->name('location.index'); // Show Location in table (return view)

Route::post('/location/store',[LocationController::class,'store'])->name('location.store'); // New Location Add Request

Route::get('/location/edit/{id}',[LocationController::class,'edit'])->name('location.edit'); // Data Edit form with data

Route::put('/location/update/{id}',[LocationController::class,'update'])->name('location.update'); // Data update request

Route::delete('/location/delete',[LocationController::class,'delete'])->name('business.delete'); //delete Request by AJAX

}); // Middleware->loginaccess End ;

Route::get('test',function(){
    return view('layouts.newlayout');
});