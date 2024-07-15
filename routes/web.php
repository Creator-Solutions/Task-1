<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

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

Route::resource('/', TaskController::class);

Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store'); // create the entry
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy'); // delete the entry
Route::get('/tasks/{id}', [TaskController::class, 'find'])->name('tasks.find'); // Locate the entry
Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update'); //update
