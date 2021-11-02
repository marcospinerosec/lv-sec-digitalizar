<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class EmpresaController extends Controller
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
        //$empresas = DB::table('BA_Empresas')->get();

        //$empresas = DB::connection('odbc-connection-name')->SELECT('call GEN_TraerEmpresas',array("",""))->get();
        //dd($request->session()->all());

        $empresas=DB::select(DB::raw("exec GEN_TraerEmpresas :Param1, :Param2"),[
            ':Param1' => '',
            ':Param2' => '',
        ]);

        /*$page = $request->query('page', 1);

        $paginate = 10;

        $offSet = ($page * $paginate) - $paginate;

        $itemsForCurrentPage = array_slice($empresas, $offSet, $paginate, true);



        $empresas = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($empresas), $paginate, $page);
        //print_r($empresas);

        $empresas->setPath(route('empresas.index'));*/
        return view('admin.empresas.index', ['empresas' => $empresas]);

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
        //
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
