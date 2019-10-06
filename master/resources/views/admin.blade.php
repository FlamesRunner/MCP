@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Administration</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p><b>Welcome to the {{ env('APP_NAME') }} administration panel.</b> Below, you'll find a set of options that you can use to manage the system.</p>
                    <p>- <a href="{{ route('adminUserList') }}">Manage users</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
