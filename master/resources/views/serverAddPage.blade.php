@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add a server</div>

                <div class="card-body" id="mainArea">
			@if ($errors->any())
                        <div class="alert alert-danger">
                        	<ul>
	        	                @foreach ($errors->all() as $error)
        	                        <li>{{ $error }}</li>
                                        @endforeach
                        	</ul>
			</div>
                        @endif

                    {{ Form::open(array('url' => route('addServerProcess'), 'id' => 'createForm')) }}
                        <label for="host"><b>Your server's IP address</b></label>
                        <input name="host" type="text" placeholder="IP address..." class="form-control" />
			<br />
                        <label for="apikey"><b>Your API key</b></label>
                        <input name="apikey" type="text" placeholder="API key..." class="form-control" />
                        <br />
                        <input type="submit" class="btn btn-primary" value="Add server"/>
                    {{ Form::close() }}
                </div>
                <div class="card-body" id="loadingArea" style="display: none">
                        <center>
                                <br />
                                <img src="/loading.gif">
                                <br />
                                <br />
                                <p>Please wait while the system processes your request. Do not refresh the page.</p>
                                <br />
                        </center>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
        $(document).ready(function() {
                console.log("Initialized.");
                $("#createForm").submit(function(event) {
                        $("#mainArea").fadeOut(500, function() {
                                $("#loadingArea").fadeIn(500);
                        });
                });
        });
</script>
@endsection