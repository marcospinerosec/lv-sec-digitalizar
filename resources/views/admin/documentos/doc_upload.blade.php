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
            {{ $documento[0]->CODIGO }} - {{ $documento[0]->NOMBREREAL }}
            <input type="hidden" name="nombrereal"  id="nombrereal" value="<?php echo str_replace(' ','_',str_replace('  ','',$documento[0]->NOMBREREAL))?>">
            <input type="hidden" name="id"  value="{{$documento[0]->ID}}">
            <input type="hidden" name="idEmpresa"  value="{{$documento[0]->IDEMPRESA}}">
        </div>
        <hr>
        <div class="form-group">
            <label for="image"><strong>{{__('Planilla de Declaración Jurada SEC')}}</strong></label>
            <input type="hidden" name="DJSECEscaneado" id="DJSECEscaneado" value="{{$documento[0]->DJSEC}}">
            <input type="file" name="DJSEC" id="fileDJSEC" class="form-control-file" id="profile-img" value="{{$documento[0]->DJSEC}}">

                <button type="button" onclick="scanToLocalDisk('<?php echo str_replace(' ','_',str_replace('  ','',$documento[0]->NOMBREREAL))?>_DJSEC');" class='btn btn-success'>Escanear</button>
            <span id="hrefDJSEC">
            @if($documento[0]->DJSEC)
                <a target="_blank" href="{{ asset('../storage/app/public/files/'.$documento[0]->DJSEC) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
                    <a href="#" onClick="quitar('DJSEC')"><i class="fas fa-trash-alt fa-2x"></i></a>
            @endif
            </span>
        </div>
        <hr>
        <div class="form-group">
            <label for="image"><strong>{{__('Constancia de CUIT')}}</strong></label>
            <input type="hidden" name="CUITEscaneado" id="CUITEscaneado" value="{{$documento[0]->CUIT}}">
            <input type="file" name="CUIT" id="fileCUIT" class="form-control-file" id="profile-img" value="{{$documento[0]->CUIT}}">
            <button type="button" onclick="scanToLocalDisk('<?php echo str_replace(' ','_',str_replace('  ','',$documento[0]->NOMBREREAL))?>_CUIT');" class='btn btn-success'>Escanear</button>
            <span id="hrefCUIT">
            @if($documento[0]->CUIT)
                <a target="_blank" href="{{ asset('../storage/app/public/files/'.$documento[0]->CUIT) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
                    <a href="#" onClick="quitar('CUIT')"><i class="fas fa-trash-alt fa-2x"></i></a>
            @endif
            </span>
        </div>
        <hr>
        <div class="form-group">
            <label for="image"><strong>{{__('Registro de Alta trabajadores AFIP')}}</strong></label>
            <input type="hidden" name="RTAFIPEscaneado" id="RTAFIPEscaneado" value="{{$documento[0]->RTAFIP}}">
            <input type="file" name="RTAFIP" id="fileRTAFIP" class="form-control-file" id="profile-img" value="{{$documento[0]->RTAFIP}}">
            <button type="button" onclick="scanToLocalDisk('<?php echo str_replace(' ','_',str_replace('  ','',$documento[0]->NOMBREREAL))?>_RTAFIP');" class='btn btn-success'>Escanear</button>
            <span id="hrefRTAFIP">
            @if($documento[0]->RTAFIP)
                <a target="_blank" href="{{ asset('../storage/app/public/files/'.$documento[0]->RTAFIP) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
                    <a href="#" onClick="quitar('RTAFIP')"><i class="fas fa-trash-alt fa-2x"></i></a>
            @endif
            </span>
        </div>
        <hr>
        <div class="form-group">
            <label for="image"><strong>{{__('Habilitación Municipal')}}</strong></label>
            <input type="hidden" name="HABMUNEscaneado" id="HABMUNEscaneado" value="{{$documento[0]->HABMUN}}">
            <input type="file" name="HABMUN" id="fileHABMUN" class="form-control-file" id="profile-img" value="{{$documento[0]->HABMUN}}">
            <button type="button" onclick="scanToLocalDisk('<?php echo str_replace(' ','_',str_replace('  ','',$documento[0]->NOMBREREAL))?>_HABMUN');" class='btn btn-success'>Escanear</button>
            <span id="hrefHABMUN">
            @if($documento[0]->HABMUN)
                    <a target="_blank" href="{{ asset('../storage/app/public/files/'.$documento[0]->HABMUN) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
                    <a href="#" onClick="quitar('HABMUN')"><i class="fas fa-trash-alt fa-2x"></i></a>
                @endif
            </span>
        </div>
        <hr>
        <div class="form-group">
            <label for="image"><strong>{{__('Planilla de jornada laboral')}}</strong></label>
            <input type="hidden" name="JORLABEscaneado" id="JORLABEscaneado" value="{{$documento[0]->JORLAB}}">
            <input type="file" name="JORLAB" id="fileJORLAB" class="form-control-file" id="profile-img" value="{{$documento[0]->JORLAB}}">
            <button type="button" onclick="scanToLocalDisk('<?php echo str_replace(' ','_',str_replace('  ','',$documento[0]->NOMBREREAL))?>_JORLAB');" class='btn btn-success'>Escanear</button>
            <span id="hrefJORLAB">
            @if($documento[0]->JORLAB)
                    <a target="_blank" href="{{ asset('../storage/app/public/files/'.$documento[0]->JORLAB) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
                    <a href="#" onClick="quitar('JORLAB')"><i class="fas fa-trash-alt fa-2x"></i></a>
                @endif
            </span>
        </div>
        <hr>
        <div class="form-group">
            <label for="image"><strong>{{__('Fotocopia DNI (si es empresa unipersonal)')}}</strong></label>
            <input type="hidden" name="DNIEscaneado" id="DNIEscaneado" value="{{$documento[0]->DNI}}">
            <input type="file" name="DNI" id="fileDNI" class="form-control-file" id="profile-img" value="{{$documento[0]->DNI}}">
            <button type="button" onclick="scanToLocalDisk('<?php echo str_replace(' ','_',str_replace('  ','',$documento[0]->NOMBREREAL))?>_DNI');" class='btn btn-success'>Escanear</button>
            <span id="hrefDNI">
            @if($documento[0]->DNI)
                    <a target="_blank" href="{{ asset('../storage/app/public/files/'.$documento[0]->DNI) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
                    <a href="#" onClick="quitar('DNI')"><i class="fas fa-trash-alt fa-2x"></i></a>
                @endif
            </span>
        </div>
        <hr>
        <div class="form-group">
            <label for="image"><strong>{{__('Contrato o Estatuto (si es una sociedad)')}}</strong></label>
            <input type="hidden" name="CONTRATOEscaneado" id="CONTRATOEscaneado" value="{{$documento[0]->CONTRATO}}">
            <input type="file" name="CONTRATO" id="fileCONTRATO" class="form-control-file" id="profile-img" value="{{$documento[0]->CONTRATO}}">
            <button type="button" onclick="scanToLocalDisk('<?php echo str_replace(' ','_',str_replace('  ','',$documento[0]->NOMBREREAL))?>_CONTRATO');" class='btn btn-success'>Escanear</button>
            <span id="hrefCONTRATO">
            @if($documento[0]->CONTRATO)
                    <a target="_blank" href="{{ asset('../storage/app/public/files/'.$documento[0]->CONTRATO) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
                    <a href="#" onClick="quitar('CONTRATO')"><i class="fas fa-trash-alt fa-2x"></i></a>
                @endif
            </span>
        </div>
        <hr>
        <div class="form-group">
            <label for="image"><strong>{{__(' Formulario 931')}}</strong></label>
            <input type="hidden" name="F931Escaneado" id="F931Escaneado" value="{{$documento[0]->F931}}">
            <input type="file" name="F931" id="fileF931" class="form-control-file" id="profile-img" value="{{$documento[0]->F931}}">
            <button type="button" onclick="scanToLocalDisk('<?php echo str_replace(' ','_',str_replace('  ','',$documento[0]->NOMBREREAL))?>_F931');" class='btn btn-success'>Escanear</button>
            <span id="hrefF931">
            @if($documento[0]->F931)
                    <a target="_blank" href="{{ asset('../storage/app/public/files/'.$documento[0]->F931) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
                    <a href="#" onClick="quitar('F931')"><i class="fas fa-trash-alt fa-2x"></i></a>
                @endif
            </span>
        </div>
        <hr>
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
                document.getElementById("formDoc").submit();
            };
            document.getElementById("fileCUIT").onchange = function() {
                document.getElementById("formDoc").submit();
            };
            document.getElementById("fileRTAFIP").onchange = function() {
                document.getElementById("formDoc").submit();
            };
            document.getElementById("fileHABMUN").onchange = function() {
                document.getElementById("formDoc").submit();
            };
            document.getElementById("fileJORLAB").onchange = function() {
                document.getElementById("formDoc").submit();
            };
            document.getElementById("fileDNI").onchange = function() {
                document.getElementById("formDoc").submit();
            };
            document.getElementById("fileCONTRATO").onchange = function() {
                document.getElementById("formDoc").submit();
            };
            document.getElementById("fileF931").onchange = function() {
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
