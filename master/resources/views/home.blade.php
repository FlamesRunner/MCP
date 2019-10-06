@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
			<h3>Welcome to mcPanel!</h3>
			<p>This is a control panel that allows you to control Minecraft servers.</p>
			<br />
			<p>Installation is fairly simple; launch a server running Debian 9 (64 bit) and execute the following commands as the root user:</p>
			<pre>
cd ~ && wget https://s.flamz.pw/dl/install.bash
chmod +x install.bash
./install.bash
			</pre>
			<p>At the end of the installation process, you will receive an API key to use on the control panel.</p>
			<p>For support inquiries or account deletion requests, please contact <a href="mailto:andrew@andrew-hong.me">andrew@andrew-hong.me</a> from your email on file.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
