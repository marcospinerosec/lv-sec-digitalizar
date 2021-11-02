@extends('admin.layouts.dashboard')

@section('content')
    @if (\Session::has('error'))
        <div class="alert alert-danger">
            <ul>
                <li>{!! \Session::get('error') !!}</li>
            </ul>
        </div>
    @endif
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
    @endif

    <div class="row py-lg-2">
        <div class="col-md-6">

        </div>

    </div>

    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            {{__('Empresas')}}</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>{{__('Codigo')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Fantasía')}}</th>
                        <th>{{__('Dirección')}}</th>

                        <th>{{__('Tools')}}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>{{__('Codigo')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Fantasía')}}</th>
                        <th>{{__('Dirección')}}</th>

                        <th>{{__('Tools')}}</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach ($empresas as $empresa)
                        <tr>
                            <td>{{ $empresa->IDEMPRESA }}</td>
                            <td>{{ $empresa->CODIGO }}</td>
                            <td>{{ $empresa->NOMBREREAL }}</td>
                            <td>{{ $empresa->NOMBREFANTASIA }}</td>
                            <td><?php
                                $address='';

                                $address .=(!is_null($empresa->CALLEREAL))?$empresa->CALLEREAL:'';
                                $address .=(!is_null($empresa->NUMEROREAL))?' '.$empresa->NUMEROREAL:'';
                                $address .=(!is_null($empresa->EXTENSIONREAL))?' '.$empresa->EXTENSIONREAL:'';
                                $address .=(!is_null($empresa->LOCALIDADREAL))?' - '.$empresa->LOCALIDADREAL:'';

                                echo $address;

                                ?></td>
                            <td>

                                <a href="{{route('documentos.doc_upload',  array('empresaId' => $empresa->IDEMPRESA))}}"><i class="fas fa-file-pdf fa-2x"></i></a>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <!--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>-->
    </div>



@endsection



