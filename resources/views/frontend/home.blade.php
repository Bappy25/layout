@extends('frontend.layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <a href="{{ URL::current() }}" class="btn btn-primary"><i class="fas fa-redo"></i></a>
                        </div>
                        <div class="col-sm-10">
                            {!! Form::open(['url' => route('home'), 'method'=>'get']) !!}
                                <div class="form-group">
                                    <div class="form-line">
                                        {!! Form::text("search", request('search'), ['class'=>'form-control', 'placeholder'=>'Search']) !!}
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    @foreach ($users as $user)
                    <h2>{{ $user->name }} <small>{{ $user->username }}</small></h2>
                    <p><a href="mailto:{{ $user->email }}" class="nav-link text-muted">{{ $user->email }}</a></p>
                    <a href="{{ route('users.profile', $user->username) }}" class="btn btn-primary mb-3"><i class="fas fa-user mr-2"></i>Show User</a>
                    <a href="{{ route('messages.create', $user->username) }}" class="btn btn-success mb-3"><i class="fas fa-envelope mr-2"></i>Message User</a>
                    <hr>
                    @endforeach
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection