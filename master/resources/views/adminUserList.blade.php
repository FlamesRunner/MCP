@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User list - <a href="{{ url()->previous() }}">Go back</a></div>

                <div class="card-body">
                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                                <ul>
                                                @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                @endforeach
                                                </ul>
                                        </div>
                                        @endif
                    @if (!empty(Session::get('message.level')))
                        <div class="alert alert-{{ Session::get('message.level') }}">
                            {{ Session::get('message.content') }}
                        </div>
                    @endif
                        <div class="table-responsive">
                                <table class="table table-bordered">
                                        <thead>
                                                <tr>
                                                        <th>Name</th>
                                                        <th>Email address</th>
                                    			<th>Actions</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                                                @forelse($users as $user)
                                                                        <tr>
                                                                        <td>{{ $user->name }}</td>
                                                                        <td>{{ $user->email }}</td>
                                                                        <td>
                                                                                {{ Form::open(array('url' => route('adminUserAct'))) }}
                                                                                        <input type="hidden" name="email" value="{{ $user->email }}" />
                                                                                        {{ Form::select('action', ['edit' => 'Edit', 'terminate' => 'Terminate'], null, ['class' => 'form-control']) }}
                                                					<br />
					                                                <input type="submit" class="btn btn-primary" value="Process" />
                                                                                {{ Form::close() }}
                                                                        </td>
                                                                @empty
                                                                <tr><td>No users found. Did something go wrong?</td><td></td><td></td><td></td></tr>
                                                                @endforelse
                                                        </tbody>
                                                </table>
                                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
