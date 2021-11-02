@extends('admin.layouts.dashboard')

@section('content')

<h1>{{__('Edit')}} {{__('Role')}}</h1>

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ url('/roles/'.$role->id) }}">
    @csrf
    @method('PATCH')

    <div class="form-group">
        <label for="role_name">{{__('Name')}}</label>
        <input type="text" name="role_name" class="form-control" id="role_name" placeholder="{{__('Name')}}..." value="{{$role->name}}" required>
    </div>
    <div class="form-group">
        <label for="role_slug">Slug</label>
        <input type="text" name="role_slug" tag="role_slug" class="form-control" id="role_slug" placeholder="Slug..." value="{{$role->slug}}" required>
    </div>
    <div class="form-group" >
        <label for="roles_permissions">{{__('Add')}} {{__('Permissions')}}</label>
        <input type="text" data-role="tagsinput" name="roles_permissions" class="form-control" id="roles_permissions" value="@foreach ($role->permissions as $permission)
            {{$permission->name. ","}}
        @endforeach">
    </div>

    <div class="form-group pt-2">
        <input class="btn btn-primary" type="submit" value="{{__('Submit')}}">
    </div>
</form>

@section('css_role_page')
    <link rel="stylesheet" href="{{asset('/css/admin/bootstrap-tagsinput.css')}}">
@endsection

@section('js_role_page')
    <script src="{{asset('/js/admin/bootstrap-tagsinput.js')}}"></script>

    <script>

        $(document).ready(function(){
            $('#role_name').keyup(function(e){
                var str = $('#role_name').val();
                str = str.replace(/\W+(?!$)/g, '-').toLowerCase();//rplace stapces with dash
                $('#role_slug').val(str);
                $('#role_slug').attr('placeholder', str);
            });
        });

    </script>

@endsection

@endsection
