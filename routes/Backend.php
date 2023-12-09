<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\DoctorController;
use App\Http\Controllers\Dashboard\SingleServiceController;
use Livewire\Livewire;
//use App\Livewire\Offers;


// Mcamara\LaravelLocalization\Middleware;
/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

Route::get('/Admin',[DashboardController::class,'index']);

###########DashBoard User###########
Route::get('/dashboard/user', function () {
    return view('Dashboard.User.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard.user');
//Dashboard Admin
Route::get('/dashboard/admin', function () {
    return view('Dashboard.Admin.dashboard');
})->middleware(['auth:admin', 'verified'])->name('dashboard.admin');

        Route::middleware(['auth:admin'])->group(function () {
        //sections route
            Route::resource('Sections', SectionController::class);
        // Doctors route
        Route::resource('Doctors', DoctorController::class);
        Route::post('update_password', [DoctorController::class, 'update_password'])->name('update_password');
        Route::post('update_status', [DoctorController::class, 'update_status'])->name('update_status');
        //Service route
        Route::resource('Service', SingleServiceController::class);
        // GroupServices route
        // Route::get('Add_GroupServices', CreateGroupServices::class)->name('Add_GroupServices');

        //Route::get('Add_GroupServices', CreateNewGroupServices ::class,'livewire.GroupServicess.include_create');
       // Route::view('GroupServices','livewire.GroupServices.include_create')->name('GroupServices');
        Route::view('Offers','livewire.include_offer')->name('Offers');
        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/custom/livewire/update', $handle);
        });

        });

require __DIR__.'/auth.php';
    });
