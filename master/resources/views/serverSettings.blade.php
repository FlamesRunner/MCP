@extends('layouts.app')

@section('content') 

<div class="container">
	<h3>Server Settings &nbsp; <span style="font-size: 12px"><a href="{{ route('manageServerPage', [$host]) }}">Back</a></span></h3>
	<hr>
	<p>Modify the server's allocated RAM and other various settings here.</p>
	<br />
    @if (!empty(Session::get('message.level')))
        <div class="alert alert-{{ Session::get('message.level') }}">
        	{{ Session::get('message.content') }}
    	</div>
    	<br />
    @endif
	{{ Form::open(array('url' => route('setRam', [$host]))) }}
	{{ csrf_field() }}
	<label for="ram">RAM allocated</label>
	<div class="input-group">
		<input name="ram" class="form-control" type="number" value="{{ $ram }}" placeholder="RAM allocated..." />
		<div class="input-group-append">
			<span class="input-group-text">MB</span>
		</div>
		<span class="input-group-append">
			<input type="submit" class="btn btn-success" value="Save" />
		</span>
	</div>
	{{ Form::close() }}
</div>
@endsection