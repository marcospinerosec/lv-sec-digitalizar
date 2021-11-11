<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DocumentoController;

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

/*Route::get('/', function () {
    return view('/home');
});*/

Auth::routes();
Route::group(['middleware' => ['web', 'AuthenticateWithSession']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('admin', 'App\Http\Controllers\AdminController@index');
    Route::get('empresas', 'App\Http\Controllers\EmpresaController@index')->name('empresas.index');


    Route::get('documentos', 'App\Http\Controllers\DocumentoController@index')->name('documentos.index');
    Route::get('doc_upload', 'App\Http\Controllers\DocumentoController@page')->name('documentos.doc_upload');
    Route::patch('store', 'App\Http\Controllers\DocumentoController@store')->name('documentos.store');
    Route::get('create', 'App\Http\Controllers\DocumentoController@create')->name('documentos.create');

    Route::delete('destroy', 'App\Http\Controllers\DocumentoController@destroy')->name('documentos.destroy');

    Route::get('/upload', [DocumentoController::class, 'upload'])->name('upload');

    Route::post('/uploadFile', [DocumentoController::class, 'uploadFile'])->name('uploadFile');


});

Route::get('no_session', 'App\Http\Controllers\DocumentoController@noSession')->name('documentos.no_session');
