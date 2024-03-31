<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

//Home
Route::get('/', [HomeController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');


//student

Route::prefix('student')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('student');
    Route::get('/list', [StudentController::class, 'list'])->name('student.list');
    Route::get('/get/{id}', [StudentController::class, 'get'])->name('student.get');
    Route::post('/store', [StudentController::class, 'store'])->name('student.store');
    Route::get('/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::post('/update/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::get('/status/{id}', [StudentController::class, 'status'])->name('student.status');
    Route::delete('/delete/{id}', [StudentController::class, 'delete'])->name('student.delete');
});

require __DIR__.'/auth.php';
