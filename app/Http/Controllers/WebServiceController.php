<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;


class WebServiceController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function verificaUsuario($username, $password)
    {
        $results = DB::select(DB::raw("exec ADM_EsUsuario :Param1, :Param2"), [
            ':Param1' => $username,
            ':Param2' => $password,
        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function esAdministrador($idUsuario)
    {
        $results=DB::select(DB::raw("exec ADM_EsAdministrador :Param1"),[
            ':Param1' => $idUsuario,
        ]);
        //dd($empresas);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function imprimeBoleta($idUsuario)
    {
        $results=DB::select(DB::raw("exec ADM_UsuarioImprimeSoloBoleta :Param1"),[
            ':Param1' => $idUsuario,
        ]);
        //dd($empresas);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function esActa($idUsuario)
    {
        $results=DB::select(DB::raw("exec DDJJ_ActaBoletasTraerPorUsuario :Param1"),[
            ':Param1' => $idUsuario,
        ]);
        //dd($empresas);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function verificaEmpleadosPorDebajoMinimo($empresa, $mes, $year)
    {
        $results = DB::select(DB::raw("exec DDJJ_VerificaEmpleadosPorDebajoMinimo :Param1, :Param2, :Param3"), [
            ':Param1' => $empresa,
            ':Param2' => $mes,
            ':Param3' => $year,
        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }



    public function empresaPorUsuario($idUsuario)
    {
        $results=DB::select(DB::raw("exec DDJJ_EmpresasPorUsuario :Param1"),[
            ':Param1' => $idUsuario,
        ]);
        //dd($empresas);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function empresaPorId($idEmpresa)
    {
        $results=DB::select(DB::raw("exec DDJJ_EmpresaPorId :Param1"),[
            ':Param1' => $idEmpresa,
        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function traerVencimiento($mes, $year, $dv)
    {
        $results=DB::select(DB::raw("exec DDJJ_VencimientoTraer :Param1, :Param2, :Param3"),[
            ':Param1' => $mes,
            ':Param2' => $year,
            ':Param3' => $dv,
        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function validaDia($fecha)
    {
        $results=DB::select(DB::raw("exec DDJJ_ValidaDia :Param1"),[
            ':Param1' => $fecha,
        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function boletaPagoImpresion($empresa, $mes, $year)
    {
        $results = DB::select(DB::raw("exec DDJJ_BoletaPagoImpresion :Param1, :Param2, :Param3"), [
            ':Param1' => $empresa,
            ':Param2' => $mes,
            ':Param3' => $year,
        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function numeroMensual($empresa, $mes, $year)
    {
        $results = DB::select(DB::raw("exec DDJJ_NumeroMensual :Param1, :Param2, :Param3"), [
            ':Param1' => $empresa,
            ':Param2' => $mes,
            ':Param3' => $year,
        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function traerPorcentajeInteres()
    {
        $results = DB::select(DB::raw("exec DDJJ_PorcentajeInteresTraer"), [

        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function verificaBoletaPago($empresa, $mes, $year)
    {
        $results = DB::select(DB::raw("exec DDJJ_BoletaPagoImpresion :Param1, :Param2, :Param3"), [
            ':Param1' => $empresa,
            ':Param2' => $mes,
            ':Param3' => $year,
        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function empleadosPorEmpresaParaDDJJ($empresa, $mes, $year)
    {
        $results = DB::select(DB::raw("exec DDJJ_EmpleadosPorEmpresaParaDDJJ :Param1, :Param2, :Param3"), [
            ':Param1' => $empresa,
            ':Param2' => $mes,
            ':Param3' => $year,
        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function guardarDDJJ($empresa, $mes, $year,$intereses,$numero,$interesesPFT,$vencimiento,$vencimientoOriginal,$mp,$idUsuario)
    {
        $vencimiento = date('Y-m-d', strtotime($vencimiento));
        $vencimientoOriginal = date('Y-m-d', strtotime($vencimientoOriginal));
        $empresa = intval($empresa);
        $mes = intval($mes);
        $year = intval($year);
        $numero = intval($numero);

        $idUsuario = intval($idUsuario);


        try {
            DB::enableQueryLog();
            /*$results = DB::select(DB::raw("exec DDJJ_GuardarDDJJ :Param1, :Param2, :Param3, :Param4, :Param5, :Param6, :Param7, :Param8, :Param9, :Param10"), [
                ':Param1' => $empresa,
                ':Param2' => $mes,
                ':Param3' => $year,
                ':Param4' => $intereses,
                ':Param5' => $numero,
                ':Param6' => $interesesPFT,
                ':Param7' => $vencimiento,
                ':Param8' => $vencimientoOriginal,
                ':Param9' => '',
                ':Param10' => $idUsuario
            ]);*/

            DB::statement("exec DDJJ_GuardarDDJJ ?, ?, ?, ?, ?, ?, ?, ?, ?, ?", [
                $empresa,
                $mes,
                $year,
                $intereses,
                $numero,
                $interesesPFT,
                $vencimiento,
                $vencimientoOriginal,
                null,
                $idUsuario
            ]);

            // Tu lógica de actualización aquí

            return response()->json(['message' => 'Datos actualizados con éxito']);
        } catch (QueryException $e) {
            // Aquí manejas la excepción
            $errorMessage = $e->getMessage();
            $errorCode = $e->getCode();

            // Obtén los parámetros utilizados en la llamada al procedimiento almacenado
            $parametros = [
                'empresa' => $empresa,
                'mes' => $mes,
                'year' => $year,
                'intereses' => $intereses,
                'numero' => $numero,
                'interesesPFT' => $interesesPFT,
                'vencimiento' => $vencimiento,
                'vencimientoOriginal' => $vencimientoOriginal,
                'mp' => $mp,
                'idUsuario' => $idUsuario,
            ];

            // Log de la excepción o cualquier otro manejo que necesites

            \Log::error("Error al ejecutar el procedimiento almacenado en " . now() . ": $errorMessage (Code: $errorCode). Parámetros: " . print_r($parametros, true));

            Log::debug('SQL Queries: '.json_encode(DB::getQueryLog()));

            // Devuelve una respuesta indicando que ha ocurrido un error
            return response()->json(['error' => 'Ha ocurrido un error al procesar la solicitud'], 500);
        }


    }

    public function guardarDDJJComprobante($empresa, $mes, $year,$numero)
    {


        $results = DB::select(DB::raw("exec DDJJ_GuardarDDJJTraerComprobante :Param1, :Param2, :Param3, :Param4"), [
            ':Param1' => $empresa,
            ':Param2' => $mes,
            ':Param3' => $year,
            ':Param4' => $numero

        ]);



        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function centralPagos($produccion)
    {
        $results = DB::select(DB::raw("exec ADM_CentralPagosDatosTraer :Param1"), [
            ':Param1' => $produccion,
        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function empleadosPorEmpresaSinNovedades($idEmpresa)
    {
        $results=DB::select(DB::raw("exec DDJJ_EmpleadosPorEmpresaSinNovedades :Param1"),[
            ':Param1' => $idEmpresa,
        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function eliminarEmpleado($idEmpleado,$idUsuario)
    {
        $results=DB::select(DB::raw("exec DDJJ_EmpleadosEliminar :Param1, :Param2"),[
            ':Param1' => $idEmpleado,
            ':Param2' => $idUsuario
        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }


    public function empleadoPorId($idEmpleado)
    {
        $results=DB::select(DB::raw("exec DDJJ_EmpleadosTraerPorId :Param1"),[
            ':Param1' => $idEmpleado,
        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function categorias()
    {
        $results = DB::select(DB::raw("exec DDJJ_CategoriasTraer"), [

        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function tiposNovedades()
    {
        $results = DB::select(DB::raw("exec DDJJ_TiposNovedadesTraer"), [

        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function empresasExceptuadasValidacionMinimoTraerPorEmpresa($idEmpresa)
    {
        $results=DB::select(DB::raw("exec BA_EmpresasExceptuadasValidacionMinimoTraerPorEmpresa :Param1"),[
            ':Param1' => $idEmpresa,
        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function empresasImporteMinimo()
    {
        $results = DB::select(DB::raw("exec BA_EmpresasImporteMinimoTraer"), [

        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }



    public function empleadosActualizar($idEmpleado, $cuil, $nombre,$idCategoria,$afiliado,$ingreso,$idNovedad,$egreso,$ia100,$ica,$idUsuario)
    {
        $ingreso = ($ingreso=='null')?null:date('Y-m-d', strtotime($ingreso));
        $egreso = ($egreso=='null')?null:date('Y-m-d', strtotime($egreso));
        $idEmpleado = intval($idEmpleado);
        $idCategoria = intval($idCategoria);
        $idNovedad = ($idNovedad=='null')?null:intval($idNovedad);
        $ia100 = floatval($ia100);
        $ica = floatval($ica);
        $afiliado = intval($afiliado);

        $idUsuario = intval($idUsuario);





        try {
            DB::enableQueryLog();


            DB::statement("exec DDJJ_EmpleadosActualizar ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?", [
                $idEmpleado,
                $cuil,
                strtoupper(urldecode(utf8_decode($nombre))),
                $idCategoria,
                $afiliado,
                $ingreso,
                $idNovedad,
                $egreso,
                $ia100,
                $ica,
                $idUsuario
            ]);

            // Tu lógica de actualización aquí

            return response()->json(['message' => 'Datos actualizados con éxito']);
        } catch (QueryException $e) {
            // Aquí manejas la excepción
            $errorMessage = $e->getMessage();
            $errorCode = $e->getCode();

            // Obtén los parámetros utilizados en la llamada al procedimiento almacenado
            /*$parametros = [
                'empleado' => $idEmpleado,
                'cuil' => $cuil,
                'nombre' => $nombre,
                'categoria' => $idCategoria,
                'afiliado' => $afiliado,
                'ingreso' => $ingreso,
                'novedad' => $idNovedad,
                'egreso' => $egreso,
                'ia100' => $ia100,
                'ica' => $ica,
                'idUsuario' => $idUsuario,
            ];

            // Log de la excepción o cualquier otro manejo que necesites

            \Log::error("Error al ejecutar el procedimiento almacenado en " . now() . ": $errorMessage (Code: $errorCode). Parámetros: " . print_r($parametros, true));

            Log::debug('SQL Queries: '.json_encode(DB::getQueryLog()));*/

            // Devuelve una respuesta indicando que ha ocurrido un error
            return response()->json(['error' => 'Ha ocurrido un error al procesar la solicitud'], 500);
        }


    }

    public function empleadosTraerPorCuil($cuil,$idEmpresa)
    {
        $results=DB::select(DB::raw("exec DDJJ_EmpleadosTraerPorCuil :Param1,:Param2"),[
            ':Param1' => $cuil,
            ':Param2' => $idEmpresa,
        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function empleadosAgregar($idEmpresa, $cuil, $nombre,$idCategoria,$afiliado,$ingreso,$idNovedad,$egreso,$ia100,$ica,$idUsuario)
    {
        $ingreso = ($ingreso=='null')?null:date('Y-m-d', strtotime($ingreso));
        $egreso = ($egreso=='null')?null:date('Y-m-d', strtotime($egreso));
        $idEmpresa = intval($idEmpresa);
        $idCategoria = intval($idCategoria);
        $idNovedad = ($idNovedad=='null')?null:intval($idNovedad);
        $ia100 = floatval($ia100);
        $ica = floatval($ica);
        $afiliado = intval($afiliado);

        $idUsuario = intval($idUsuario);





        try {
            DB::enableQueryLog();


            DB::statement("exec DDJJ_EmpleadosAgregar ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?", [
                $idEmpresa,
                $cuil,
                strtoupper(urldecode(utf8_decode($nombre))),
                $idCategoria,
                $afiliado,
                $ingreso,
                $idNovedad,
                $egreso,
                $ia100,
                $ica,
                $idUsuario
            ]);

            // Tu lógica de actualización aquí

            return response()->json(['message' => 'Datos actualizados con éxito']);
        } catch (QueryException $e) {
            // Aquí manejas la excepción
            $errorMessage = $e->getMessage();
            $errorCode = $e->getCode();

            // Obtén los parámetros utilizados en la llamada al procedimiento almacenado
            /*$parametros = [
                'empleado' => $idEmpleado,
                'cuil' => $cuil,
                'nombre' => $nombre,
                'categoria' => $idCategoria,
                'afiliado' => $afiliado,
                'ingreso' => $ingreso,
                'novedad' => $idNovedad,
                'egreso' => $egreso,
                'ia100' => $ia100,
                'ica' => $ica,
                'idUsuario' => $idUsuario,
            ];

            // Log de la excepción o cualquier otro manejo que necesites

            \Log::error("Error al ejecutar el procedimiento almacenado en " . now() . ": $errorMessage (Code: $errorCode). Parámetros: " . print_r($parametros, true));

            Log::debug('SQL Queries: '.json_encode(DB::getQueryLog()));*/

            // Devuelve una respuesta indicando que ha ocurrido un error
            return response()->json(['error' => 'Ha ocurrido un error al procesar la solicitud'], 500);
        }


    }

    public function ddjjHistorial($idEmpresa,$year)
    {
        $results=DB::select(DB::raw("exec DDJJ_ConsultaHistorialTotales :Param1,:Param2"),[
            ':Param1' => $idEmpresa,
            ':Param2' => $year,
        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }

    public function ddjjHistorialVencimientosAnteriores($idEmpresa,$year,$mes,$envio)
    {
        $results=DB::select(DB::raw("exec DDJJ_ConsultaHistorialTotalesVencAnteriores :Param1,:Param2,:Param3,:Param4"),[
            ':Param1' => $idEmpresa,
            ':Param2' => $year,
            ':Param3' => $mes,
            ':Param4' => $envio,
        ]);

        // Convertir propiedades de tipo cadena a UTF-8
        foreach ($results as &$result) {
            foreach ($result as $key => &$value) {
                if (is_string($value)) {
                    $value = utf8_encode($value);
                }
            }
        }

        return response()->json(['result' => $results]);
    }


    public function importarEmpleados(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
            'idEmpresa' => 'required|integer',
            'idUsuario' => 'required|integer',
        ]);

        // Retrieve the file and parameters
        $file = $request->file('file');
        $idEmpresa = $request->input('idEmpresa');
        $idUsuario = $request->input('idUsuario');

        // Definir la ruta de destino donde se guardará el archivo
        $destinationPath = public_path('files');

        // Asegurarse de que el directorio 'files' exista
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Mover el archivo al directorio 'files' con un nombre único
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $destinationPath . '/' . $fileName;
        $file->move($destinationPath, $fileName);

        try {

            // Call the stored procedure with the line data
            $result = DB::statement('exec DDJJ_EmpleadosImportarArchivo ?, ?, ?', [$filePath,$idEmpresa, $idUsuario]);


            return response()->json(['success' => true, 'message' => 'Archivo guardado y enviado para procesamiento.']);

        } catch (\Exception $e) {
            Log::error('Error al procesar el archivo: ' . $e->getMessage());
            return response()->json(['error' => 'Error al procesar el archivo en el SP.'], 500);
        }

    }

    public function importarEmpleados_new(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
            'idEmpresa' => 'required|integer',
            'idUsuario' => 'required|integer',
        ]);

        // Retrieve the file and parameters
        $file = $request->file('file');
        $idEmpresa = $request->input('idEmpresa');
        $idUsuario = $request->input('idUsuario');

        // Open the file and read it line by line
        $path = $file->getRealPath();
        $fileHandle = fopen($path, 'r');

        if ($fileHandle === false) {
            return response()->json(['error' => 'Unable to open file'], 500);
        }

        DB::beginTransaction();

        try {
            DB::statement('exec DDJJ_EmpleadosEliminar ?', [$idEmpresa]);
            while (($line = fgets($fileHandle)) !== false) {
                $line = trim($line);
                // Log the line before and after conversion
                Log::debug('Raw Line: ' . $line);
                // Detect encoding and convert to UTF-8 if necessary
                /*$encoding = mb_detect_encoding($line, 'UTF-8, ISO-8859-1', true);
                if ($encoding != 'UTF-8') {
                    $line = mb_convert_encoding($line, 'UTF-8', $encoding);
                    Log::debug('Converted Line: ' . $line);
                }*/




                // Skip empty lines
                if (empty($line)) {
                    continue;
                }

                // Call the stored procedure with the line data
                $result = DB::statement('exec DDJJ_EmpleadosImportarArchivo_Nuevo ?, ?, ?', [$idEmpresa, $idUsuario, $line /* add other parameters if needed */]);

                // Log result

                Log::debug('Stored Procedure Result: ' . $result);
            }

            fclose($fileHandle);

            Log::debug('Before commit');
            DB::commit();
            Log::debug('Transaction committed');

            return response()->json(['success' => 'File processed successfully'], 200);

        } catch (\Exception $e) {
            Log::error('Error caught: ' . $e->getMessage());
            DB::rollBack();
            fclose($fileHandle);

            return response()->json(['error' => 'Error processing file: ' . $e->getMessage()], 500);
        } finally {
            if (isset($fileHandle) && is_resource($fileHandle)) {
                fclose($fileHandle);
            }
        }
    }


}
