@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Minecraft Servers - <a href="{{ route('addServer') }}">Add server</a></div>

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
                   @if (!empty(Session::get('message.level')))
                   <div class="alert alert-{{ Session::get('message.level') }}">
                    {{ Session::get('message.content') }}
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Host</th>
                                <th>API key (redacted)</th>
                                <th>Created on</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($servers as $server)
                            <tr>
                                <td>{{ $server->host }}</td>
                                <td>{{ substr($server->apikey, 0, 4) }}******{{ substr($server->apikey, -4, strlen($server->apikey)) }}</td>
                                <td>{{ $server->created_at }}</td>
                                <td>
                                    {{ Form::open(array('url' => route('deleteServerProcess'))) }}
                                    <input type="hidden" name="host" value="{{ $server->host }}" />
                                    <div class="btn-group" role="group">
                                        <input type="submit" class="btn btn-danger" value="Remove" onclick="loading()" />
                                        {{ Form::close() }}
                                        <a href="{{ route('manageServerPage', ["host" => $server->host]) }}" class="btn btn-success">Manage server</a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4">No servers found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
    function loading() {
        $("#mainArea").fadeOut(500, function() {
            $("#loadingArea").fadeIn(500);
        });
    }
</script>
@endsection
