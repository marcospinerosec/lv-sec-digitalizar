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
        {{__('Pagos')}}</div>
    <div class="card-body">
        <div class="table-responsive">

            <ul>
                @foreach ($files as $file)
                <li>{{ $file }}</li>
                @endforeach
            </ul>

        </div>
    </div>

    <!--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>-->
</div>



@endsection



