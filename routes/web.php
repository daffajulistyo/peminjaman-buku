<?php

use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Backend\BookController;
use App\Http\Controllers\Backend\LoanRequestController;
use App\Http\Controllers\Backend\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('book')->group(function () {
    Route::get('list_book', [BookController::class, 'index'])->name('book.index');
    Route::post('/insert_book', [BookController::class, 'store'])->name('book.insert');
    Route::get('/add_book', [BookController::class, 'create'])->name('book.show');
    Route::get('/edit_book/{id}', [BookController::class, 'edit'])->name('book.edit');
    Route::post('/update_book/{id}', [BookController::class, 'update'])->name('book.update');
    Route::get('/delete_book/{id}', [BookController::class, 'destroy'])->name('book.delete');
});
Route::prefix('user')->group(function () {
    Route::get('list_user', [UserController::class, 'index'])->name('user.index');
    Route::post('/insert_user', [UserController::class, 'store'])->name('user.insert');
    Route::get('/add_user', [UserController::class, 'create'])->name('user.show');
    Route::get('/edit_user/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/update_user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/delete_user/{id}', [UserController::class, 'destroy'])->name('user.delete');
});

Route::prefix('loan')->group(function () {
    Route::get('list_loan', [LoanRequestController::class, 'index'])->name('loan.index');
    Route::resource('loan-requests', LoanRequestController::class);
    Route::put('loan-requests/{loan_request}/approve', [LoanRequestController::class, 'approve'])->name('loan-requests.approve');
    Route::put('loan-requests/{loan_request}/reject', [LoanRequestController::class, 'reject'])->name('loan-requests.reject');
    Route::post('list_request', [LoanRequestController::class, 'store'])->name('request.store');
});

Route::prefix('admin')->group(function () {
    Route::get('list', [LoanRequestController::class, 'list'])->name('list.loans.index');
    Route::put('loans/{loan_request}/return', [LoanRequestController::class, 'returnBook'])->name('list.loans.return');
});

Route::prefix('member')->group(function () {
    Route::get('add-request', [LoanRequestController::class, 'create'])->name('request.index');
    Route::get('list-book', [LoanRequestController::class, 'listBookMember'])->name('member.book.index');
});
