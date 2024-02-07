<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\WebServiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('/verifica-usuario/{username}/{password}', [WebServiceController::class, 'verificaUsuario']);
Route::get('/es-administrador/{idUsuario}', [WebServiceController::class, 'esAdministrador']);
Route::get('/imprime-boleta/{idUsuario}', [WebServiceController::class, 'imprimeBoleta']);
Route::get('/es-acta/{idUsuario}', [WebServiceController::class, 'esActa']);
Route::get('/verifica-empleado-debajo-minimo/{empresa}/{mes}/{year}', [WebServiceController::class, 'verificaEmpleadosPorDebajoMinimo']);
Route::get('/empresa-usuario/{idUsuario}', [WebServiceController::class, 'empresaPorUsuario']);
Route::get('/empresa/{idEmpresa}', [WebServiceController::class, 'empresaPorId']);
Route::get('/vencimiento-traer/{mes}/{year}/{dv}', [WebServiceController::class, 'traerVencimiento']);
Route::get('/valida-dia/{fecha}', [WebServiceController::class, 'validaDia']);
Route::get('/boleta-pago-impresion/{empresa}/{mes}/{year}', [WebServiceController::class, 'boletaPagoImpresion']);
Route::get('/numero-mensual/{empresa}/{mes}/{year}', [WebServiceController::class, 'numeroMensual']);
Route::get('/porcentaje-interes-traer', [WebServiceController::class, 'traerPorcentajeInteres']);
