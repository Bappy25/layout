@extends('backend.layouts.master')

@section('title')
MDB Admin Panel
@endsection

@section('content')
<div class="block-header">
    <h2>ADMINISTRATORS</h2>
</div>
<!-- Basic Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    ALL ADMINISTRATORS
                    <small>View all administrators</small>
                </h2>
            </div>
            <div class="body table-responsive">
                <div class="row">
                    <div class="col-md-2">
                        <a href="{{ URL::current() }}" class="btn btn-primary waves-effect">
                            <i class="material-icons">refresh</i>
                            <span>Refresh</span>
                        </a>
                    </div>
                    <div class="col-md-2 pull-right">
                        {!! Form::open(['url' => route('admins.index'), 'method'=>'get']) !!}
                            <div class="form-group">
                                <div class="form-line">
                                    {!! Form::text("search", null, ['class'=>'form-control', 'placeholder'=>'Search']) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>CREATED AT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- #END# Basic Table -->
@endsection

@section('custom-script')

<!-- Demo Js -->
{{Html::script('js/backend/script.js')}}

@endsection