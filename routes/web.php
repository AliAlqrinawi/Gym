<?php

use App\Http\Controllers\CouponController;
use App\Http\Controllers\DayTableController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\weekDaysControllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::middleware('auth')->get('/', function () {return redirect('/admin');});

Auth::routes();

Route::group([
    'prefix' => LaravelLocalization::setLocale().'/admin',
    'middleware' => ['auth']
],function () {
    Route::get('/', function () {return view('dashboard.dashboard');})->name('home');
    Route::resource('table' , TableController::class);
    Route::put('status/table/{id}', [TableController::class , 'status']);

    Route::resource('weekDay' , weekDaysControllers::class);
    Route::put('status/weekDay/{id}', [weekDaysControllers::class , 'status']);

    Route::resource('dayTable' , DayTableController::class);
    Route::put('status/dayTable/{id}', [DayTableController::class , 'status']);

    Route::resource('exercise' , ExerciseController::class);
    Route::put('status/exercise/{id}', [ExerciseController::class , 'status']);

    
    Route::resource('video' , VideoController::class);
    Route::put('status/video/{id}', [VideoController::class , 'status']);
    Route::resource('coupon' , CouponController::class);
    Route::put('status/coupon/{id}', [CouponController::class , 'status']);
    Route::resource('package' , PackageController::class);
    Route::put('status/package/{id}', [PackageController::class , 'status']);
    Route::resource('layout' , LayoutController::class);
    Route::put('status/layout/{id}', [PackageController::class , 'status']);
    Route::resource('role' , RoleController::class);
    Route::resource('setting', SettingsController::class)->only(['index' , 'update']);
});

Route::get('test' , function(){
    return App\Models\Table::where('is_parent' , 'parent')->with('weekDay')->get();
});
