<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


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


        $results = DB::select(DB::raw("exec DDJJ_GuardarDDJJ :Param1, :Param2, :Param3, :Param4, :Param5, :Param6, :Param7, :Param8, :Param9, :Param10"), [
             ':Param1' => $empresa,
             ':Param2' => $mes,
             ':Param3' => $year,
            ':Param4' => $intereses,
            ':Param5' => $numero,
            ':Param6' => $interesesPFT,
            ':Param7' => $vencimiento,
            ':Param8' => $vencimientoOriginal,
            ':Param9' => $mp,
            ':Param10' => $idUsuario
        ]);

        // Tu lógica de actualización aquí

        return response()->json(['message' => 'Datos actualizados con éxito']);
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


}
