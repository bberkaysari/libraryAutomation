<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ReaderController;
use App\Models\Author;
use App\Models\Book;
use App\Models\Categories;
use App\Models\Reader;
use App\Models\Transaction;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Models\Transactions;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Ana sayfa
Route::view('/', 'welcome');

// Dashboard rotası, kullanıcı doğrulaması ve e-posta doğrulaması gerektiriyor
Route::get('/dashboard', function () {
    $authors = Author::all();
    $categories = Categories::all();
    $readers = Reader::all();
    $books= Book::all();
    $transactions = Transactions::all();
    return view('dashboard', compact('authors', 'categories','readers','books','transactions'));
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');//Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
//Route::get('transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
//Route::post('books/{book}/toggle-status', [App\Http\Controllers\BookController::class, 'toggleStatus'])->name('books.toggleStatus');
Route::post('/books/{id}/toggle-status', [BookController::class, 'toggleStatus'])->name('books.toggleStatus');
// Profil sayfası
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Kitap ekleme sayfası
//Route::get('/admin/books/create', [BookController::class, 'create'])->name('books.create');
//Route::post('/admin/books/store', [BookController::class, 'store'])->name('books.store');
//Route::get('/dashboard',[DashboardController::class,'adminDashboard'])->name('dashboard');
//Route::get('/user/dashboard',[DashboardController::class,'userDashboard'])->name('user.dashboard');
// Yazarlar için kaynak rotaları
Route::resource('authors', AuthorController::class);
Route::resource('categories', CategoriesController::class);
Route::resource('readers', ReaderController::class);
Route::resource('transactions', TransactionController::class);
Route::resource('admin', AdminController::class);
Route::resource('user', UserController::class);
Route::resource('books', BookController::class);
Route::get('/books', [BookController::class, 'index'])->name('books.index');

/*Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:1'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});*/
/*Route::middleware(['auth','role:reader'])->group(function () {
    Route::get('/reader/dashboard', [ReaderController::class, 'dashboard'])->name('reader.dashboard');
});*/
/*Route::middleware(['auth','role:1'])->group(function () {
    Route::get('/user/dashboard', [ReaderController::class, 'dashboard'])->name('reader.dashboard');
});*/

/*Route::prefix('user')->name('user.')->middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});*/

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

// Dashboard yönlendirme
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('admin');
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});

/*Route::middleware('admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});
*/

// Authentication ile ilgili route'lar
require __DIR__.'/auth.php';