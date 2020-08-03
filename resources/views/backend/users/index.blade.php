@extends('backend.layouts.master')

@section('title')
All Users
@endsection

@section('content')

<div class="block-header">
    <ol class="breadcrumb breadcrumb-col-teal">
        <li><i class="material-icons">people</i> Users</li>
        <li class="active"><i class="material-icons">list</i> All Users</li>
    </ol>
</div>

<!-- Users Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    All Users
                    <small>Here is the list of all users</small>
                </h2>
            </div>
            <div class="body table-responsive">
                <div class="row-clearfix">
                    <div class="col-md-2">
                        <a href="{{ URL::current() }}" class="btn btn-primary waves-effect">
                            <i class="material-icons">refresh</i>
                            <span>Refresh</span>
                        </a>
                    </div>
                    <div class="col-md-2 pull-right">
                        {!! Form::open(['url' => route('back.users.index'), 'method'=>'get']) !!}
                            <div class="form-group">
                                <div class="form-line">
                                    {!! Form::text("search", $search, ['class'=>'form-control', 'placeholder'=>'Search']) !!}
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
                            <th>USERNAME</th>
                            <th>EMAIL</th>
                            <th>STATUS</th>
                            <th>CREATED AT</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td><a href="mailto:{{ $user->email }}" class="nav-link text-muted">{{ $user->email }}</a></td>
                            <td>
                                {!! empty($user->email_verified_at) ? '<span class="label label-danger">Not Verified</span>' : '<span class="label label-success">Verified</span>' !!}
                            </td>
                            <td>{{ $user->created_at->format('d/m/y, h:m a') }}</td>
                            <td>
                                {!! Form::open(['route' => ['back.users.destroy', $user->id], 'method'=>'delete']) !!}
                                <a class="btn btn-primary" href="{{route('back.users.show', $user->id)}}" title="Show User"><i class="material-icons">open_in_browser</i></a>
                                {!! Form::button('<i class="material-icons">delete</i>', array('class' => 'btn btn-danger form_warning_sweet_alert', 'title'=>'Delete User', 'text'=>'are you sure?', 'confirmButtonText'=>'Yes!', 'type'=>'submit')) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
<!-- #END# Users Table -->
@endsection

@section('custom-script')

<!-- Backend Script -->
{{Html::script('js/backend/script.js')}}

@endsection