<?php

use App\Http\Controllers\CreateTaskController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UpdateTaskController;
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

Route::get('/', HomeController::class)->name('home');
Route::get('/create-task', [CreateTaskController::class , 'showForm'])->name('create-task');
Route::get('/update-task/{id}', [UpdateTaskController::class , 'showForm'])->name('update-task');
