<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return auth()->user() ? redirect()->route('home') : view('auth.login');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware(['auth']);

Route::group(['middleware' => 'auth'], function () {

    //CRUD работа с контактами
    Route::resource('contacts', App\Http\Controllers\ContactsController::class);

    //обработка ajax запросов на получение контактов и переключатель "избранное"
    Route::prefix('contacts')->group(function () {

        Route::post('datatables-data/{favouriteCriteria?}', [App\Http\Controllers\ContactsController::class, 'dataTablesData'])
            ->name('contacts.datatables-data');

        Route::patch('contacts.toggle-favourite/{contact}', [App\Http\Controllers\ContactsController::class, 'toggleFavourite'])
            ->name('contacts.toggle-favourite');

    });

    //работа с токенами (генерирование, отзыв)
    Route::prefix('token')->group(function () {

        Route::get('/', [App\Http\Controllers\TokenController::class, 'index'])->name('token.index');
        Route::get('generate', [App\Http\Controllers\TokenController::class, 'generate'])->name('token.generate');
        Route::get('delete', [App\Http\Controllers\TokenController::class, 'delete'])->name('token.delete');

    });

});
