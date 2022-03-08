@extends('admin.layouts.dashboard')

@section('content')

    <h1><?php echo utf8_encode($nombre) ?></h1>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{route('documentos.store')}}" enctype="multipart/form-data">
        @method('PATCH')
        @csrf()

        <div class="form-group">
            <label for="nombre"><strong>{{__('Empresa')}}</strong></label>
            {{ $empresa[0]->CODIGO }} - <?php echo utf8_encode($empresa[0]->NOMBREREAL) ?>
            <input type="hidden" name="nombrereal"  id="nombrereal" value="<?php echo str_replace(' ','_',str_replace('  ','',quitar_tildes(utf8_encode($empresa[0]->NOMBREREAL))))?>">
            <input type="hidden" name="idEmpresa"  value="{{$empresa[0]->IDEMPRESA}}">
            <input type="hidden" name="<?php echo trim($sigla);?>Escaneado" id="<?php echo trim($sigla);?>Escaneado" value="">
            <input type="hidden" name="<?php echo trim($sigla);?>ID" id="<?php echo trim($sigla);?>ID" value="<?php echo $idDoc;?>">
            <input type="hidden" name="<?php echo trim($sigla);?>VALIDAR" id="<?php echo trim($sigla);?>VALIDAR" value="1">

            <input type="hidden" name="idDocumento"  id="idDocumento" value="<?php echo $idDocumento;?>">

        </div>

        <div class="form-group">
            <label for="image"><strong>{{__('Documento')}}</strong></label>


            <input type="file" name="<?php echo trim($sigla);?>" id="file<?php echo trim($sigla);?>" class="form-control-file" id="profile-img" value="">

            <button type="button" onclick="scanToLocalDisk('<?php echo str_replace(' ','_',str_replace('  ','',quitar_tildes(utf8_encode($empresa[0]->NOMBREREAL))))?>_{{$sigla}}');" class='btn btn-success'>Escanear</button>


            <span id="hrefDocumento">

            </span>
        </div>


        <div class="form-group pt-2">
            <input class="btn btn-primary" type="submit" value="{{__('Submit')}}">

            <a href="{{route('documentos.doc_upload',array('empresaId'=>$empresa[0]->IDEMPRESA)) }}" class="btn btn-success m-1">Volver</a>
        </div>
    </form>


@endsection
