<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\TransactionController;
use \App\Http\Controllers\UserController;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'loginPost'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('transactions/edit/{transaction}', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('transactions/update/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('transactions/destroy', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    Route::get('transactions/view/{transaction}', [TransactionController::class, 'view'])->name('transactions.view');
    Route::get('transactions/{id}/invoice', [TransactionController::class, 'invoice'])->name('transactions.invoice');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/update/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/destroy', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/email/check', [UserController::class, 'emailcheck'])->name('users.emailcheck');

    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.index');
    Route::put('/profile', [AuthController::class, 'update'])->name('password.update');
});