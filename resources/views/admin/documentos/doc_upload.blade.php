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




    <form id="formDoc" method="POST" action="{{route('documentos.store')}}" enctype="multipart/form-data">
        @method('PATCH')
        @csrf()

        <div class="form-group">
            <label for="nombre"><strong>{{__('Empresa')}}</strong></label>
            {{ $empresa[0]->CODIGO }} - <?php echo utf8_encode($empresa[0]->NOMBREREAL) ?>
            <input type="hidden" name="nombrereal"  id="nombrereal" value="<?php echo str_replace(' ','_',str_replace('  ','',quitar_tildes($empresa[0]->NOMBREREAL)))?>">
            <input type="hidden" name="idDocumento"  id="idDocumento" value="">
            <input type="hidden" name="idEmpresa"  value="{{$empresa[0]->IDEMPRESA}}">
        </div>
        <hr>
        @foreach($documentos as $documento)
            @php
            $nombreDoc='';
            $idDoc='';
            @endphp
            @foreach($documentosEmpresas as $documentoEmpresa)

                    @php
                    if ($documento->ID==$documentoEmpresa->IDDOCUMENTO){
                        $nombreDoc=$documentoEmpresa->NOMBRE;
                        $idDoc=$documentoEmpresa->ID;
                    }
                    @endphp

            @endforeach

        <div class="form-group">
            <label for="image"><strong><?php echo utf8_encode($documento->NOMBRE); ?></strong></label>
            <input type="hidden" name="<?php echo trim($documento->SIGLA);?>Escaneado" id="<?php echo trim($documento->SIGLA);?>Escaneado" value="{{$nombreDoc}}">
            <input type="hidden" name="<?php echo trim($documento->SIGLA);?>ID" id="<?php echo trim($documento->SIGLA);?>ID" value="{{$idDoc}}">

            <input type="file" name="<?php echo trim($documento->SIGLA);?>" id="file<?php echo trim($documento->SIGLA);?>" class="form-control-file" id="profile-img" value="">

                <button type="button" onclick="scanToLocalDisk('<?php echo str_replace(' ','_',str_replace('  ','',$empresa[0]->NOMBREREAL))?>_{{$documento->SIGLA}}');" class='btn btn-success'>Escanear</button>
            <span id="href<?php echo trim($documento->SIGLA);?>">
                 @if($nombreDoc)
                    <a target="_blank" href="{{ asset('../storage/app/public/files/'.$nombreDoc) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
                    <a href="#" onClick="quitar('<?php echo trim($documento->SIGLA);?>')"><i class="fas fa-trash-alt fa-2x"></i></a>
                @endif
            </span>
        </div>
        <hr>
        @endforeach
        <div id="server_response"></div>
        <div id="response"></div>
        <!--<div class="form-group pt-2">
            <input class="btn btn-primary" type="submit" value="{{__('Submit')}}">
        </div>-->
    </form>
    <div class="row py-lg-2">


        <div class="col-md-6">
            <a href="{{route('documentos.create',  array('empresaId' => $empresa[0]->IDEMPRESA))}}" class="btn btn-primary float-md-left" role="button" aria-pressed="true">{{__('Nuevo')}}</a>
        </div>

    </div>
    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            {{__('Otros Documentos')}}

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Id</th>

                        <th>{{__('User')}}</th>
                        <th>{{__('Alta')}}</th>
                        <th>{{__('Detalle')}}</th>
                        <th>{{__('Tools')}}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Id</th>

                        <th>{{__('User')}}</th>
                        <th>{{__('Alta')}}</th>
                        <th>{{__('Detalle')}}</th>
                        <th>{{__('Tools')}}</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach ($otrosDocumentos as $otroDocumento)
                        <tr>
                            <td>{{ $otroDocumento->ID }}</td>



                            <td>{{ $otroDocumento->UsuarioNT }}</td>
                            <td>{{($otroDocumento->FECHAALTA)?date('d/m/Y H:i', strtotime($otroDocumento->FECHAALTA)):''}}</td>
                            <td>{{ $otroDocumento->DETALLE }}</td>
                            <td>
                                <div class="d-flex">
                                @if($otroDocumento->NOMBRE)
                                    <a target="_blank" href="{{ asset('../storage/app/public/files/'.$otroDocumento->NOMBRE ) }}"><i class="fas fa-file-pdf fa-3x"></i></a>
                                @endif
                                    <form action="{{ route('documentos.destroy', array('id' => $otroDocumento->ID)) }}" method="POST" onsubmit="return  ConfirmDelete()">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button class="btn btn-danger m-1"><i class="fas fa-trash-alt fa"></i></button>
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

        function ConfirmDelete()
        {
            var x = confirm("Eliminar archivo?");
            if (x)
                return true;
            else
                return false;
        }

        $(function() {
            document.getElementById("fileDJSEC").onchange = function() {
                document.getElementById('idDocumento').value = 1;
                document.getElementById("formDoc").submit();
            };
            document.getElementById("fileCUIT").onchange = function() {
                document.getElementById('idDocumento').value = 2;
                document.getElementById("formDoc").submit();
            };
            document.getElementById("fileRTAFIP").onchange = function() {
                document.getElementById('idDocumento').value = 3;
                document.getElementById("formDoc").submit();
            };
            document.getElementById("fileHABMUN").onchange = function() {
                document.getElementById('idDocumento').value = 4;
                document.getElementById("formDoc").submit();
            };
            document.getElementById("fileJORLAB").onchange = function() {
                document.getElementById('idDocumento').value = 5;
                document.getElementById("formDoc").submit();
            };
            document.getElementById("fileDNI").onchange = function() {
                document.getElementById('idDocumento').value = 6;
                document.getElementById("formDoc").submit();
            };
            document.getElementById("fileCONTRATO").onchange = function() {
                document.getElementById('idDocumento').value = 7;
                document.getElementById("formDoc").submit();
            };
            document.getElementById("fileF931").onchange = function() {
                document.getElementById('idDocumento').value = 8;
                document.getElementById("formDoc").submit();
            };
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
