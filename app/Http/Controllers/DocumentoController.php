<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use Session;
use Validator;
use Illuminate\Support\Facades\Log;
use DB;
use App\Models\User;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class DocumentoController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('web');
    }

    public function noSession()
    {
        return view('admin.documentos.no_session');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $empresa_id= $request->query('empresaId');

        $documentos=DB::select(DB::raw("exec GEN_TraerEmpresaDocumentosPorIdEmpresa :Param1"),[
            ':Param1' => $empresa_id,

        ]);

        //Log::info('Hay datos: ' . count($documentos),[]);


        return view('admin.documentos.index', ['documentos' => $documentos]);

    }



    function page(Request $request)
    {


        $empresa_id= $request->query('empresaId');


        $empresa=DB::select(DB::raw("exec GEN_TraerEmpresaPorId :Param1"),[
            ':Param1' => $empresa_id,

        ]);

        //$documentos=DB::select(DB::raw("exec GEN_TraerDocumentosObligatorios"));

        /*$otrosDocumentos=DB::select(DB::raw("exec GEN_TraerEmpresaOtrosDocumentosPorIdEmpresa :Param1"),[
            ':Param1' => $empresa_id,

        ]);*/

        $documentosEmpresas=DB::select(DB::raw("exec GEN_TraerEmpresaDocumentosPorIdEmpresa :Param1"),[
            ':Param1' => $empresa_id,

        ]);
        //print_r($documento);
        return view('admin.documentos.doc_upload', ['documentosEmpresas' => $documentosEmpresas, 'empresa' => $empresa]);
    }


    public function uploadFile(Request $request){

        // Validation
        $request->validate([
            'file' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf|max:2048'
        ]);

        if($request->file('file')) {
            $file = $request->file('file');
            $filename = time().'_'.$file->getClientOriginalName();

            // File upload location
            $location = 'files';

            // Upload file
            $file->move($location,$filename);

            Session::flash('message','Upload Successfully.');
            Session::flash('alert-class', 'alert-success');
        }else{
            Session::flash('message','File not uploaded.');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('/');
    }






    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


        $empresa_id= $request->query('empresaId');
        $empresa=DB::select(DB::raw("exec GEN_TraerEmpresaPorId :Param1"),[
            ':Param1' => $empresa_id,

        ]);

        $documentos=DB::select(DB::raw("exec GEN_TraerDocumentosObligatorios"));

        return view('admin.documentos.create', ['empresa' => $empresa, 'documentos' => $documentos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the field
        /*$data = request()->validate([
            'codigo' => 'required|max:255',
            'nombre' => 'required|max:255'

        ]);*/


        $arrayValidation = [];



        $empresa = request('nombrereal');

        $idEmpresa = request('idEmpresa');

        $codigoEmpresa = request('codigoEmpresa');
        $idDocumento = (request('idDocumento'))?request('idDocumento'):null;



        $detalle = (request('Detalle'))?request('Detalle'):null;
        if (request('procesarDetalle')){
            $arrayValidation['idDocumento'] = 'required';
            $arrayValidation['documento'] = 'required|mimes:jpg,jpeg,pdf|max:2048';
            if ( !in_array($idDocumento, array('1','2','3','4'), true ) ) {
                $arrayValidation['Detalle'] = 'required';
            }

        }


        //Log::debug((array) $arrayValidation);
        // Validation
        $request->validate($arrayValidation);
        //Log::debug('Llegué a la validación');
        //dd($request->all());

        //dd(session()->all());
        //Log::debug('Pasé la validación');


        $newFileNameDocumento=null;
        if (request('documento')){

            //get the image from the form
            $DocumentoF=$request->file('documento');
            $fileNameWithTheExtension = $DocumentoF->getClientOriginalName();

            //get the name of the file
            $fileName = pathinfo($fileNameWithTheExtension, PATHINFO_FILENAME);

            //get extension of the file
            $extension = $DocumentoF->getClientOriginalExtension();

            //create a new name for the file using the timestamp
            //$newFileNameDocumento = $empresa . '_'.date('Y_m_d_H_i_s').'.' . $extension;

            $newFileNameDocumento = $codigoEmpresa.'_'.$idDocumento . '_'.date('Y_m_d_H_i_s').'.' . $extension;

            //save the iamge onto a public directory into a separately folder
            //$path = $DocumentoF->storeAs('public/files', $newFileNameDocumento);
            $store  = Storage::disk('nas')->put($newFileNameDocumento, File::get($DocumentoF));

            // dd($extension);
        }elseif (request('docEscaneado')){
            $pos      = strripos(request('docEscaneado'), '/');
            $newFileNameDocumento = str_replace('"]', '', substr(request('docEscaneado'), $pos));
        }
        //$idDocumento = (request('idDocumento'))?request('idDocumento'):null;





        $user = $request->session()->get('user');




        Log::debug('idEmpresa: '.$idEmpresa);
        Log::debug('user: '.$user->id);
        Log::debug('idDocumento: '.$idDocumento);
        Log::debug('detalle: '.$detalle);
        Log::debug('newFileNameDocumento: '.$newFileNameDocumento);

        try{

            $insertarDocumento=DB::select(DB::raw("exec GEN_ACTUALIZARDocumento :Param1, :Param2, :Param3, :Param4, :Param5"),[
                ':Param1' => $idEmpresa,
                ':Param2' => $user->id,
                ':Param3' => $idDocumento,
                ':Param4' => $detalle,
                ':Param5' => $newFileNameDocumento,

            ]);



            $ok=1;


        }
        catch(QueryException $ex){
            $error = $ex->getMessage();
            $ok=0;

        }

        if($ok){
            $suc='success';
            $detalle = 'Documentos actualizados!';
        }
        else{
            $suc='error';
            $detalle = $error;
        }

        $redirect = redirect()->route('documentos.doc_upload', ['empresaId' => $idEmpresa])->with($suc, $detalle);



        return $redirect;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $empresa_id= $request->query('empresaId');
        $nombre= $request->query('nombre');
        $sigla= $request->query('sigla');
        $idDoc= $request->query('idDoc');
        $empresa=DB::select(DB::raw("exec GEN_TraerEmpresaPorId :Param1"),[
            ':Param1' => $empresa_id,

        ]);
        switch ($sigla) {
            case 'DJSEC':
                $idDocumento=1;
                break;
            case 'CUIT':
                $idDocumento=2;
                break;
            case 'RTAFIP':
                $idDocumento=3;
                break;
            case 'HABMUN':
                $idDocumento=4;
                break;
            case 'JORLAB':
                $idDocumento=5;
                break;
            case 'DNI':
                $idDocumento=6;
                break;
            case 'CONTRATO':
                $idDocumento=7;
                break;
            case 'F931':
                $idDocumento=8;
                break;

        }



        return view('admin.documentos.edit', ['empresa' => $empresa,'nombre' => $nombre,'sigla' => $sigla,'idDocumento' => $idDocumento,'idDoc' => $idDoc]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->query('id');
        $documento=DB::select(DB::raw("exec GEN_TraerDocumentoPorId :Param1"),[
            ':Param1' => $id,

        ]);

        $idEmpresa = $documento[0]->IDEMPRESA;
        Log::debug((array) $documento);

        $oldImage = base_path().'/nas/files/'. trim($documento[0]->NOMBRE)  ;

        if(file_exists($oldImage)){
            //delete the image
            unlink($oldImage);
        }

        $user = $request->session()->get('user');
        try{
            $documento=DB::select(DB::raw("exec GEN_BorrarDocumento :Param1, :Param2"),[
                ':Param1' => $id,
                ':Param2' => $user->id,
            ]);
        }
        catch(QueryException $ex){
            $error = $ex->getMessage();
            $ok=0;

        }



        return redirect()->route('documentos.doc_upload', ['empresaId' => $idEmpresa])->with('success','Registro eliminado satisfactoriamente');
    }
}
