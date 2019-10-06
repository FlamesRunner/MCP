@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile</div>

                <div class="card-body">
                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                        @endforeach
                                        </div>
                                        @endif
                                        @if (!empty(Session::get('message.level')))
                                                <div class="alert alert-{{ Session::get('message.level') }}">
                                                        {{ Session::get('message.content') }}
                                                </div>
                                        @endif
                        {{ Form::open(array('url' => route('updatePageProcess'))) }}
                                <div class="input-group">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text">Full  name</span>
                                        </div>
                                                <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" placeholder="Your full name" />
                                        </div>
                                        <br />
                                        <div class="input-group">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text">Email</span>
                                        </div>
                                                <input type="text" class="form-control" value="{{ Auth::user()->email }}" placeholder="Your email address..." readonly="readonly" />
                                        </div>
                                        <br />
                                        <div class="input-group">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text">New password (8-128 characters long)</span>
                                        </div>
                                                <input type="password" class="form-control" name="password" placeholder="New password..." />
                                        </div>
                                        <br />
                                        <input style="float: right" type="submit" class="btn btn-success" value="Update profile" />
                                {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
