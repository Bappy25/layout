@extends('backend.layouts.master')

@section('title')
All Administrators
@endsection

@section('extra-css')

<!-- Bootstrap Tagsinput Css -->
{{ Html::style('plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}

@endsection

@section('content')

<div class="block-header">
    <ol class="breadcrumb breadcrumb-col-teal">
        <li><i class="material-icons">verified_user</i> Administrators</li>
        <li class="active"><i class="material-icons">list</i> All Administrators</li>
    </ol>
</div>

<!-- Admins Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    All Administrators
                    <small>Here is the list of all administrators</small>
                </h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NAME</th>
                                <th>EMAIL</th>
                                <th>CREATED AT</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>NAME</th>
                                <th>EMAIL</th>
                                <th>CREATED AT</th>
                                <th>ACTION</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($admins as $admin)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->created_at->format('d/m/y, h:m a') }}</td>
                                <td>
                                    {!! Form::open(['route' => ['back.admins.destroy', $admin->id], 'method'=>'delete']) !!}
                                    <a class="btn btn-warning" href="{{route('back.admins.edit', $admin->id)}}" title="Edit Administrator"><i class="material-icons">edit</i></a>
                                    {!! Form::button('<i class="material-icons">delete</i>', array('class' => 'btn btn-danger form_warning_sweet_alert', (Auth::guard('admin')->user()->id == $admin->id || $admin->first()->id == $admin->id ) ? 'disabled' : '', 'title'=>'Delete Administrator', 'text'=>'Once deleted the administrator cannot be restored', 'confirmButtonText'=>'Yes!', 'type'=>'submit')) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Admins Table -->
@endsection

@section('extra-script')

<!-- Jquery DataTable Plugin Js -->
{{Html::script('plugins/jquery-datatable/jquery.dataTables.js')}}
{{Html::script('plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}
{{Html::script('plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}
{{Html::script('plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}
{{Html::script('plugins/jquery-datatable/extensions/export/jszip.min.js')}}
{{Html::script('plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}
{{Html::script('plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}
{{Html::script('plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}
{{Html::script('plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}

@endsection

@section('custom-script')

{{Html::script('js/backend/pages/tables/jquery-datatable.js')}}

<!-- Backend Script -->
{{Html::script('js/backend/script.js')}}

@endsection