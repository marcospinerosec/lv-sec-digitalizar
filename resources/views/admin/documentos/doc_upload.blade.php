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
    <!-- if validation in the controller fails, show the errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h1>{{__('Digitalización')}}</h1>



    <label for="nombre"><strong>{{__('Empresa')}}</strong></label>
    {{ $empresa[0]->CODIGO }} - <?php echo ($empresa[0]->NOMBREREAL) ?>

    <div class="row py-lg-2">


        <div class="col-md-6">
            <a href="{{route('documentos.create',  array('empresaId' => $empresa[0]->IDEMPRESA))}}" class="btn btn-primary float-md-left" role="button" aria-pressed="true">{{__('Nuevo')}}</a>
        </div>

    </div>
    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            {{__('Documentos')}}

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>{{__('Tipo Documento')}}</th>
                        <th>{{__('Detalle')}}</th>
                        <th>{{__('Alta')}}</th>
                        <th>{{__('User')}}</th>
                        <th>{{__('Tools')}}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>{{__('Tipo Documento')}}</th>
                        <th>{{__('Detalle')}}</th>
                        <th>{{__('Alta')}}</th>
                        <th>{{__('User')}}</th>


                        <th>{{__('Tools')}}</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach ($documentosEmpresas as $documentoEmpresa)
                        <tr>
                            <td>{{ $documentoEmpresa->ID }}</td>
                            <td>{{ $documentoEmpresa->TIPODOCUMENTO }}</td>
                            <td>{{ $documentoEmpresa->DETALLE }}</td>
                            <td>{{($documentoEmpresa->FECHAALTA)?date('d/m/Y H:i', strtotime($documentoEmpresa->FECHAALTA)):''}}</td>
                            <td><?php echo ($documentoEmpresa->UsuarioNT); ?></td>




                            <td>
                                <div class="d-flex">
                                    @if($documentoEmpresa->NOMBRE)

                                        <a target="_blank" href="{{ asset('../nas/files/'.$documentoEmpresa->NOMBRE ) }}"><i class="fas fa-file-pdf fa-2x"></i></a>

                                    @endif
                                    <form name="formDelete" id="formDelete<?php echo $documentoEmpresa->ID; ?>" action="{{ route('documentos.destroy', array('id' => $documentoEmpresa->ID)) }}" method="POST" onsubmit="return  ConfirmDelete(<?php echo $documentoEmpresa->ID; ?>)">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <!--<button class="btn btn-primary m-1"><i class="fas fa-trash-alt fa"></i></button>-->
                                        <a href="#" onClick="return  ConfirmDelete(<?php echo $documentoEmpresa->ID; ?>);"><i class="fas fa-trash-alt fa-2x"></i></a>

                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <!--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>-->
    </div>
@section('js_documento_page')

    <script>

        function ConfirmDelete(id)
        {
            var x = confirm("Eliminar archivo?");
            if (x){
                document.getElementById('formDelete'+id).submit();
                return true;
            }

            else
                return false;
        }

        $(function() {

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#profile-img-tag').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#profile-img").change(function(){
                readURL(this);
            });



        });




    </script>


@endsection

@endsection
