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
            {{__('Documentos')}}</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>{{__('Empresa')}}</th>
                        <th>{{__('DJSEC')}}</th>
                        <th>{{__('CUIT')}}</th>
                        <th>{{__('RTAFIP')}}</th>
                        <th>{{__('User')}}</th>
                        <th>{{__('Alta')}}</th>

                        <th>{{__('Tools')}}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>{{__('Empresa')}}</th>
                        <th>{{__('DJSEC')}}</th>
                        <th>{{__('CUIT')}}</th>
                        <th>{{__('RTAFIP')}}</th>
                        <th>{{__('User')}}</th>
                        <th>{{__('Alta')}}</th>

                        <th>{{__('Tools')}}</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach ($documentos as $documento)
                        <tr>
                            <td>{{ $documento->ID }}</td>
                            <td>{{ $documento->NOMBREREAL }}</td>
                            <td>
                                @if($documento->DJSEC)
                                    <a target="_blank" href="{{ asset('../storage/app/public/files/'.$documento->DJSEC ) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
                                @endif

                                </td>
                            <td>
                                @if($documento->CUIT)
                                    <a target="_blank" href="{{ asset('../storage/app/public/files/'.$documento->CUIT ) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
                                @endif

                            </td>
                            <td>
                                @if($documento->RTAFIP)
                                    <a target="_blank" href="{{ asset('../storage/app/public/files/'.$documento->RTAFIP ) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
                                @endif

                            </td>
                            <td></td>
                            <td>{{($documento->FECHAALTA)?date('d/m/Y H:i', strtotime($documento->FECHAALTA)):''}}</td>
                            <td>

                                <a href="{{route('documentos.doc_upload',  array('documentoId' => $documento->ID))}}"><i class="fas fa-file-image fa-2x"></i></a>
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



