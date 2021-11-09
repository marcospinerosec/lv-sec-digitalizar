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
            <input type="hidden" name="nombrereal"  id="nombrereal" value="<?php echo str_replace(' ','_',str_replace('  ','',$empresa[0]->NOMBREREAL))?>">
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

@section('js_documento_page')

    <script>



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
