<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DocumentoController;
use App\SoapService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Soap;

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

    Route::get('edit', 'App\Http\Controllers\DocumentoController@edit')->name('documentos.edit');


    Route::delete('destroy', 'App\Http\Controllers\DocumentoController@destroy')->name('documentos.destroy');

    Route::get('/upload', [DocumentoController::class, 'upload'])->name('upload');

    Route::post('/uploadFile', [DocumentoController::class, 'uploadFile'])->name('uploadFile');

    Route::get('/listar-pagos', function () {
        // Obtener la lista de archivos en el directorio del servidor SFTP
        $files = Storage::disk('sftp')->files('/');

        return view('pagos', ['files' => $files]);
    });



});

Route::get('no_session', 'App\Http\Controllers\DocumentoController@noSession')->name('documentos.no_session');
Route::get('postDebt', 'App\Http\Controllers\PagosAPIController@postDebt')->name('pagos.postDebt');
Route::get('getDebt', 'App\Http\Controllers\PagosAPIController@getDebt')->name('pagos.getDebt');
Route::get('copyAll', 'App\Http\Controllers\PagoController@copyAll')->name('pago.copyAll');
Route::get('moveAll', 'App\Http\Controllers\PagoController@moveAll')->name('pago.moveAll');
Route::post('/soap', function (Request $request) {
    $soapServer = new SoapServer(null, [
        'uri' => '/soap',
    ]);

    $soapServer->setObject(new SoapService());

    ob_start();
    $soapServer->handle($request->getContent());
    $response = ob_get_clean();

    return response($response, 200)->header('Content-Type', 'text/xml');
})->name('soap');;


