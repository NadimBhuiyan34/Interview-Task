<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserinfoController;
use App\Models\UserInfo;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    // return view('dashboard');
    $employees = UserInfo::latest()->paginate(3);
    return view('dashboard', compact('employees'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::resource('userinfos', UserinfoController::class)->middleware(['auth', 'verified']);
require __DIR__.'/auth.php';

Route::redirect('/', 'login');
