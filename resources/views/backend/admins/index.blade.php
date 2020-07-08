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
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);">Action</a></li>
                            <li><a href="javascript:void(0);">Another action</a></li>
                            <li><a href="javascript:void(0);">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>FIRST NAME</th>
                            <th>LAST NAME</th>
                            <th>USERNAME</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr>
                        <tr>
                            <th scope="row">4</th>
                            <td>Larry</td>
                            <td>Jellybean</td>
                            <td>@lajelly</td>
                        </tr>
                        <tr>
                            <th scope="row">5</th>
                            <td>Larry</td>
                            <td>Kikat</td>
                            <td>@lakitkat</td>
                        </tr>
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