<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\Authenticate;
use App\Http\Controllers\Home;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PackageItemController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
/*1
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// https://www.twilio.com/blog/build-restful-api-php-laravel-sanctum
// Route::post('/me', [AuthController::class, 'me']);


Route::post('/register', [Authenticate::class,'registration']);
Route::post('/login', [Authenticate::class,'authenticate']);
Route::get('/my-appointment/{id}', [AppointmentController::class, 'myAppointment']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    // User
    Route::get('/myProfile', [Authenticate::class, 'myProfile']);
    Route::post('/signout', [Authenticate::class,'signout']);
    
    // Address links to the User who created it.
    Route::get('/myAddress', [Home::class, 'allAddress']);
    Route::post('/addAddress', [Home::class, 'addAddress']);
    Route::put('/updateAddress/{id}', [Home::class, 'updateAddress']);
    Route::delete('/removeAddress/{id}', [Home::class, 'removeAddress']);

    // Items
    Route::get('/allItems', [ItemController::class, 'getAllItems']);
    Route::post('/addItem', [ItemController::class, 'addItems']);
    Route::put('/updateItem/{id}', [ItemController::class, 'updateItem']);
    Route::delete('/removeItem/{id}', [ItemController::class, 'removeItem']);

    // PackageItem
    Route::get('/allPackageItems', [PackageItemController::class, 'getAllPackageItems']);
    Route::post('/createPackageItem', [PackageItemController::class, 'addPackageItem']);
    Route::put('/updatePackageItem/{id}', [PackageItemController::class, 'updatePackageItem']);
    Route::delete('/removePackageItem/{id}', [PackageItemController::class, 'removePackageItem']);

    // Appointment
    Route::get('/all-appointments', [AppointmentController::class, 'allAppointment']);
    
    Route::post('/make-appointment', [AppointmentController::class, 'makeAppointment']);

    // Doctor
    Route::get('/all-doctors', [DoctorController::class, 'getAllDoctors']);
    Route::post('/add-doctor', [DoctorController::class, 'addDoctor']);
    Route::put('/update-doctor/{id}', [DoctorController::class, 'updateDoctor']);
    Route::delete('/remove-doctor/{id}', [DoctorController::class, 'removeDoctor']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});