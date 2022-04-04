@extends('admin.layouts.dashboard')

@section('content')

    <h1>{{__('Nuevo Documento')}}</h1>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"  action="{{route('documentos.store')}}" enctype="multipart/form-data">
        @method('PATCH')
        @csrf()

        <div class="form-group">
            <label for="nombre"><strong>{{__('Empresa')}}</strong></label>
            {{ $empresa[0]->CODIGO }} - <?php echo utf8_encode($empresa[0]->NOMBREREAL) ?>
            <input type="hidden" name="nombrereal"  id="nombrereal" value="<?php echo str_replace(' ','_',str_replace('  ','',quitar_tildes(utf8_encode($empresa[0]->NOMBREREAL))))?>">
            <input type="hidden" name="idEmpresa"  value="{{$empresa[0]->IDEMPRESA}}">
            <input type="hidden" name="procesarDetalle"  value="1">
        </div>

        <div class="form-group" style="display: flex;">
            <label for="content"><strong>{{__('ID Documento')}}</strong></label>
            <select class="form-control" name="idDocumento" id="idDocumento" style="width: 300px;">
                <option value="">{{__('Select')}}...</option>
                @foreach ($documentos as $documento)

                    @if(old('idDocumento') == $documento->ID)

                        <option data-role-id="{{$documento->ID}}" value="{{$documento->ID}}" selected><?php echo $documento->NOMBRE; ?></option>
                    @else
                        <option data-role-id="{{$documento->ID}}" value="{{$documento->ID}}"><?php echo $documento->NOMBRE; ?></option>
                    @endif



                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="image"><strong>{{__('Documento')}}</strong></label>
            <input type="hidden" name="docEscaneado" id="docEscaneado" value="">


            <input type="file" name="documento" id="fileDocumento" class="form-control-file" id="profile-img" value="">

            <button type="button" onclick="scanToLocalDisk('<?php echo str_replace(' ','_',str_replace('  ','',quitar_tildes(utf8_encode($empresa[0]->NOMBREREAL))))?>_{{ date('Y_m_d_H_i_s') }}');" class='btn btn-success'>Escanear</button>
            <span id="hrefDocumento">

            </span>
        </div>
        <div class="form-group">
            <label for="content">{{__('Detalle')}}</label>
            <textarea name="Detalle" class="form-control" id="Detalle">{{ old('Detalle') }}</textarea>
        </div>

        <div class="form-group pt-2">
            <input class="btn btn-primary" type="submit" value="{{__('Submit')}}">

            <a href="{{route('documentos.doc_upload',array('empresaId'=>$empresa[0]->IDEMPRESA)) }}" class="btn btn-success m-1">Volver</a>
        </div>
    </form>


@endsection
