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
        if (count($documentos)==0){


            try{
                $insertarDocumento=DB::select(DB::raw("exec GEN_InsertarEmpresaDocumento :Param1, :Param2, :Param3, :Param4, :Param5"),[
                    ':Param1' => $empresa_id,
                    ':Param2' => null,
                    ':Param3' => null,
                    ':Param4' => null,
                    ':Param5' => null,

                ]);
            }
            catch(QueryException $ex){
                $error = $ex->getMessage();
                $ok=0;

            }
        }

        return view('admin.documentos.index', ['documentos' => $documentos]);

    }

    function page(Request $request)
    {

        Log::info('Entra: ',[]);
        $empresa_id= $request->query('empresaId');
        /*$user_id= $request->query('userId');
        if ($user_id){
            $user = new User();
            $user->id=$user_id;
            $request->session()->put('user', $user);
        }
        else{*/
            $user = $request->session()->get('user');
        //}


        $documentos=DB::select(DB::raw("exec GEN_TraerEmpresaDocumentosPorIdEmpresa :Param1"),[
            ':Param1' => $empresa_id,

        ]);

        //Log::info('Hay datos: ' . count($documentos),[]);
        if (count($documentos)==0){


            try{
                $insertarDocumento=DB::select(DB::raw("exec GEN_InsertarEmpresaDocumento :Param1, :Param2, :Param3, :Param4, :Param5"),[
                    ':Param1' => $empresa_id,
                    ':Param2' => null,
                    ':Param3' => null,
                    ':Param4' => null,
                    ':Param5' => null,

                ]);
            }
            catch(QueryException $ex){
                $error = $ex->getMessage();
                $ok=0;

            }
        }



        $documento=DB::select(DB::raw("exec GEN_TraerEmpresaDocumentosPorIdEmpresa :Param1"),[
            ':Param1' => $empresa_id,

        ]);
        //print_r($documento);
        return view('admin.documentos.doc_upload', ['documento' => $documento]);
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
    public function create()
    {
        //
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
        $empresa = request('nombrereal');
        $id = request('id');
        $idEmpresa = request('idEmpresa');
        $newFileNameDJSEC=null;
        if (request('DJSEC')){
            //get the image from the form
            $DJSECF=$request->file('DJSEC');
            $fileNameWithTheExtension = $DJSECF->getClientOriginalName();

            //get the name of the file
            $fileName = pathinfo($fileNameWithTheExtension, PATHINFO_FILENAME);

            //get extension of the file
            $extension = $DJSECF->getClientOriginalExtension();

            //create a new name for the file using the timestamp
            $newFileNameDJSEC = $empresa . '_DJSEC.' . $extension;

            //save the iamge onto a public directory into a separately folder
            $path = $DJSECF->storeAs('public/files', $newFileNameDJSEC);

            // dd($extension);
        }
        elseif (request('DJSECEscaneado')){
            $pos      = strripos(request('DJSECEscaneado'), '/');
            $newFileNameDJSEC = str_replace('"]', '', substr(request('DJSECEscaneado'), $pos));
        }
        $newFileNameCUIT=null;
        if (request('CUIT')){
            //get the image from the form
            $CUITF=$request->file('CUIT');
            $fileNameWithTheExtension = $CUITF->getClientOriginalName();

            //get the name of the file
            $fileName = pathinfo($fileNameWithTheExtension, PATHINFO_FILENAME);

            //get extension of the file
            $extension = $CUITF->getClientOriginalExtension();

            //create a new name for the file using the timestamp
            $newFileNameCUIT = $empresa . '_CUIT.' . $extension;

            //save the iamge onto a public directory into a separately folder
            $path = $CUITF->storeAs('public/files', $newFileNameCUIT);

            // dd($extension);
        }
        elseif (request('CUITEscaneado')){
            $pos      = strripos(request('CUITEscaneado'), '/');
            $newFileNameCUIT = str_replace('"]', '', substr(request('CUITEscaneado'), $pos));
        }
        $newFileNameRTAFIP=null;
        if (request('RTAFIP')){
            //get the image from the form
            $RTAFIPF=$request->file('RTAFIP');
            $fileNameWithTheExtension = $RTAFIPF->getClientOriginalName();

            //get the name of the file
            $fileName = pathinfo($fileNameWithTheExtension, PATHINFO_FILENAME);

            //get extension of the file
            $extension = $RTAFIPF->getClientOriginalExtension();

            //create a new name for the file using the timestamp
            $newFileNameRTAFIP = $empresa . '_RTAFIP.' . $extension;

            //save the iamge onto a public directory into a separately folder
            $path = $RTAFIPF->storeAs('public/files', $newFileNameRTAFIP);

            // dd($extension);
        }
        elseif (request('RTAFIPEscaneado')){
            $pos      = strripos(request('RTAFIPEscaneado'), '/');
            $newFileNameRTAFIP = str_replace('"]', '', substr(request('RTAFIPEscaneado'), $pos));
        }
        $newFileNameHABMUN=null;
        if (request('HABMUN')){
            //get the image from the form
            $HABMUNF=$request->file('HABMUN');
            $fileNameWithTheExtension = $HABMUNF->getClientOriginalName();

            //get the name of the file
            $fileName = pathinfo($fileNameWithTheExtension, PATHINFO_FILENAME);

            //get extension of the file
            $extension = $HABMUNF->getClientOriginalExtension();

            //create a new name for the file using the timestamp
            $newFileNameHABMUN = $empresa . '_HABMUN.' . $extension;

            //save the iamge onto a public directory into a separately folder
            $path = $HABMUNF->storeAs('public/files', $newFileNameHABMUN);

            // dd($extension);
        }elseif (request('HABMUNEscaneado')){
            $pos      = strripos(request('HABMUNEscaneado'), '/');
            $newFileNameHABMUN = str_replace('"]', '', substr(request('HABMUNEscaneado'), $pos));
        }
        $newFileNameJORLAB=null;
        if (request('JORLAB')){
            //get the image from the form
            $JORLABF=$request->file('JORLAB');
            $fileNameWithTheExtension = $JORLABF->getClientOriginalName();

            //get the name of the file
            $fileName = pathinfo($fileNameWithTheExtension, PATHINFO_FILENAME);

            //get extension of the file
            $extension = $JORLABF->getClientOriginalExtension();

            //create a new name for the file using the timestamp
            $newFileNameJORLAB = $empresa . '_JORLAB.' . $extension;

            //save the iamge onto a public directory into a separately folder
            $path = $JORLABF->storeAs('public/files', $newFileNameJORLAB);

            // dd($extension);
        }elseif (request('JORLABEscaneado')){
            $pos      = strripos(request('JORLABEscaneado'), '/');
            $newFileNameJORLAB = str_replace('"]', '', substr(request('JORLABEscaneado'), $pos));
        }
        $newFileNameDNI=null;
        if (request('DNI')){
            //get the image from the form
            $DNIF=$request->file('DNI');
            $fileNameWithTheExtension = $DNIF->getClientOriginalName();

            //get the name of the file
            $fileName = pathinfo($fileNameWithTheExtension, PATHINFO_FILENAME);

            //get extension of the file
            $extension = $DNIF->getClientOriginalExtension();

            //create a new name for the file using the timestamp
            $newFileNameDNI = $empresa . '_DNI.' . $extension;

            //save the iamge onto a public directory into a separately folder
            $path = $DNIF->storeAs('public/files', $newFileNameDNI);

            // dd($extension);
        }elseif (request('DNIEscaneado')){
            $pos      = strripos(request('DNIEscaneado'), '/');
            $newFileNameDNI = str_replace('"]', '', substr(request('DNIEscaneado'), $pos));
        }
        $newFileNameCONTRATO=null;
        if (request('CONTRATO')){
            //get the image from the form
            $CONTRATOF=$request->file('CONTRATO');
            $fileNameWithTheExtension = $CONTRATOF->getClientOriginalName();

            //get the name of the file
            $fileName = pathinfo($fileNameWithTheExtension, PATHINFO_FILENAME);

            //get extension of the file
            $extension = $CONTRATOF->getClientOriginalExtension();

            //create a new name for the file using the timestamp
            $newFileNameCONTRATO = $empresa . '_CONTRATO.' . $extension;

            //save the iamge onto a public directory into a separately folder
            $path = $CONTRATOF->storeAs('public/files', $newFileNameCONTRATO);

            // dd($extension);
        }elseif (request('CONTRATOEscaneado')){
            $pos      = strripos(request('CONTRATOEscaneado'), '/');
            $newFileNameCONTRATO = str_replace('"]', '', substr(request('CONTRATOEscaneado'), $pos));
        }
        $newFileNameF931=null;
        if (request('F931')){
            //get the image from the form
            $F931F=$request->file('F931');
            $fileNameWithTheExtension = $F931F->getClientOriginalName();

            //get the name of the file
            $fileName = pathinfo($fileNameWithTheExtension, PATHINFO_FILENAME);

            //get extension of the file
            $extension = $F931F->getClientOriginalExtension();

            //create a new name for the file using the timestamp
            $newFileNameF931 = $empresa . '_F931.' . $extension;

            //save the iamge onto a public directory into a separately folder
            $path = $F931F->storeAs('public/files', $newFileNameF931);

            // dd($extension);
        }elseif (request('F931Escaneado')){
            $pos      = strripos(request('F931Escaneado'), '/');
            $newFileNameF931 = str_replace('"]', '', substr(request('F931Escaneado'), $pos));
        }
        try{
            if (!$newFileNameDJSEC){
                $oldImage = storage_path() . '/app/public/files/'. $empresa . '_DJSEC.pdf' ;

                if(file_exists($oldImage)){
                    //delete the image
                    unlink($oldImage);
                }


            }
            if (!$newFileNameCUIT){
                $oldImage = storage_path() . '/app/public/files/'. $empresa . '_CUIT.pdf';

                if(file_exists($oldImage)){
                    //delete the image
                    unlink($oldImage);
                }

            }
            if (!$newFileNameRTAFIP){
                $oldImage = storage_path() . '/app/public/files/'. $empresa . '_RTAFIP.pdf';

                if(file_exists($oldImage)){
                    //delete the image
                    unlink($oldImage);
                }

            }
            if (!$newFileNameHABMUN){
                $oldImage = storage_path() . '/app/public/files/'. $empresa . '_HABMUN.pdf' ;

                if(file_exists($oldImage)){
                    //delete the image
                    unlink($oldImage);
                }


            }
            if (!$newFileNameJORLAB){
                $oldImage = storage_path() . '/app/public/files/'. $empresa . '_JORLAB.pdf' ;

                if(file_exists($oldImage)){
                    //delete the image
                    unlink($oldImage);
                }


            }
            if (!$newFileNameDNI){
                $oldImage = storage_path() . '/app/public/files/'. $empresa . '_DNI.pdf' ;

                if(file_exists($oldImage)){
                    //delete the image
                    unlink($oldImage);
                }


            }
            if (!$newFileNameCONTRATO){
                $oldImage = storage_path() . '/app/public/files/'. $empresa . '_CONTRATO.pdf' ;

                if(file_exists($oldImage)){
                    //delete the image
                    unlink($oldImage);
                }


            }
            if (!$newFileNameF931){
                $oldImage = storage_path() . '/app/public/files/'. $empresa . '_F931.pdf' ;

                if(file_exists($oldImage)){
                    //delete the image
                    unlink($oldImage);
                }


            }
            $user = $request->session()->get('user');
            $updateDocumento=DB::select(DB::raw("exec GEN_ModificarEmpresaDocumento :Param1, :Param2, :Param3, :Param4, :Param5, :Param6, :Param7, :Param8, :Param9, :Param10"),[
                ':Param1' => $id,
                ':Param2' => $newFileNameDJSEC,
                ':Param3' => $newFileNameCUIT,
                ':Param4' => $newFileNameRTAFIP,
                ':Param5' => $newFileNameHABMUN,
                ':Param6' => $newFileNameJORLAB,
                ':Param7' => $newFileNameDNI,
                ':Param8' => $newFileNameCONTRATO,
                ':Param9' => $newFileNameF931,
                ':Param10' => $user->id,

            ]);
        }
        catch(QueryException $ex){
            $error = $ex->getMessage();
            $ok=0;

        }


        /*$user = auth()->user();
        $municipio = new Municipio();

        $municipio->codigo = request('codigo');
        $municipio->nombre = request('nombre');
        $municipio->descripcion = request('descripcion');
        $municipio->image_url = $newFileName;
        $municipio->userId = $user->id;

        $municipio->save();*/

        $redirect = redirect()->route('documentos.doc_upload', ['empresaId' => $idEmpresa])->with('success', 'Documentos actualizados!');



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
    public function edit($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
