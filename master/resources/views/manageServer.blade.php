@extends('layouts.app')

@section('content')

<style>
	.ui-progressbar-value {
  		transition: width 0.5s;
  		-webkit-transition: width 0.5s;
	}
	@media (max-width: 768px) {
  		[class*="col-"] {
      		margin-bottom: 15px;
  		}
	}
</style>

<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Processing</h5>
			</div>
			<div class="modal-body">
				<p id="modalText"></p>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="statusModal" tabindex="1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="statusModalTitle"></h5>
			</div>
			<div class="modal-body">
				<p id="statusModalText"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12 mb-3 mb-md-0">
			<div class="card">
				<div class="card-header text-white" style="background-color: #34BDEB">Console <span id="mcVersion"></span></div>
                <div class="card-body">
                	<textarea style="resize: none; color: white; background-color: black" id="consolelog" class="form-control" readonly="readonly" rows="10">Loading...</textarea>
                	<br />
                	<div class="input-group">
                		<input name="cmd" id="cmd" class="form-control" placeholder="Command..." />
                		<span class="input-group-append">
                			<button class="btn btn-default" id="toggleAutoScroll">Disable autoscroll</button>
                		</span>
                		<span class="input-group-append">
                			<button class="btn btn-success" id="submitCmd">Send command</button>
                		</span>
                	</div>
                </div>
			</div>
		</div>
	</div>
	<br /> 
    <div class="row">
        <div class="col-md-8 mb-3 mb-md-0">
            <div class="card">
                <div class="card-header text-white" style="background-color: #34BDEB">Server info ({{ $host }})</div>
                <div class="card-body">
                	<p><b>Players:</b> <span id="playerCount">Unknown</span></p>
                	RAM usage
					<div class="progress" style="height: 40px">
						<div id="rusg" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%"></div>
					</div>
                	<br />
                	CPU usage
					<div class="progress" style="height: 40px">
						<div id="cusg" class="progress-bar bg-info progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%"></div>
					</div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3 mb-md-0">
        	<div class="card">
        		<div class="card-header text-white" style="background-color: #34BDEB">Server controls</div>
        		<div class="card-body">
        			<p>Here, you can start and stop your server as needed, or access the file manager.</p>
        			<p><b>Power level:</b> <span id="powerlevel"></span></p>
				<div class="btn-group">
	        			<button id="start" class="btn btn-success">Start server</button> 
	        			<button id="stop" class="btn btn-secondary">Stop server</button> 
					<button id="kill" class="btn btn-danger">Kill server</button>
				</div>
				<br />
				<br />
				<div class="btn-group">
					<a href="#" onClick="window.open('{{ route('fileManager', [$host]) }}','File Management','resizable=no,menubar=no,height=800,width=1200'); return false;" class="btn btn-primary">File Management</a>
					<a href="{{ route('serverSettings', [$host]) }}" style="color: white" class="btn btn-info">Server settings</a>
        		</div>
        	</div>
        </div>
    </div>
</div>

<script>
	function statusChange(status) {
		var msg = "";
		console.log("Executed")
		var finalStatus = "Online";
		if (status == "online") {
			msg = "Please wait for the server to come online. This can take up to 15 seconds."
			finalStatus = "Online";
		} else if (status == "offline") {
			msg = "Please wait for the server to go offline. This can take up to 15 seconds."
			finalStatus = "Offline";
		}
		$("#modalText").text(msg);
		$('#loadingModal').modal({
    		backdrop: 'static',
    		keyboard: false
		})
		var loadingLoop = setInterval(function() {
			$.get("{{ route('serverStatus', [$host]) }}", function(data) {
				var serverStatus = jQuery.parseJSON(data);
				if ($.trim(serverStatus.power) == finalStatus) {
					$("#loadingModal").modal('hide');
					clearInterval(loadingLoop);
					$("#statusModalTitle").text("Success");
					$("#statusModalText").text("The server is now " + status + ".");
					$("#statusModal").modal();
				}
			});
		}, 3000);
	}

	function toggleBtns(status) {
		if ($.trim(status) == "Online") {
			$("#submitCmd").removeAttr('disabled');
			$("#cmd").removeAttr('disabled');
			$("#kill").removeAttr('disabled');
			$("#stop").removeAttr('disabled');
			$("#start").attr('disabled', 'disabled');
		} else {
			$("#submitCmd").attr('disabled', 'disabled');
			$("#cmd").attr('disabled', 'disabled');
			$("#start").removeAttr('disabled');
			$("#kill").attr('disabled', 'disabled');
			$("#stop").attr('disabled', 'disabled');
		}
	}

	function update() {
		$.get("{{ route('serverStatus', [$host]) }}", function(data) {
			var serverStatus = jQuery.parseJSON(data);
			$("#rusg").width($.trim(serverStatus.ram) + "%");
			$("#cusg").width($.trim(serverStatus.cpu) + "%");
			$("#powerlevel").text(serverStatus.power);
			if ($.trim($("#powerlevel").text()) == "Online") {
				$("#powerlevel").css({'color': 'green'});
			} else {
				$("#powerlevel").css({'color': 'red'});
			}
			toggleBtns(serverStatus.power)
		});
		if ($.trim($("#powerlevel").text()) == "Online") {
			$.get("{{ route('serverPing', [$host]) }}", function (data) {
				var serverData = jQuery.parseJSON(data);
				$("#mcVersion").html("(" + serverData.version.name + ")");
				$("#playerCount").html(serverData.players.online + "/" + serverData.players.max);
			});
		} else {
			$("#playerCount").html("(none, server is offline)");
			$("#mcVersion").html("");
		}
	}
	$(document).ready(function() {
		update();
		var updateLoop = setInterval(function() { 
			update();
		}, 3000);
		var consoleLoop = setInterval(function() {
			$.get("{{ route('consoleLog', [$host]) }}", function(data) {
				$("#consolelog").text(data);
				if ($("#toggleAutoScroll").html() == "Disable autoscroll") {
					$('#consolelog').scrollTop($("#consolelog")[0].scrollHeight - $("#consolelog").height());
				}
			});
		}, 1000);
		$.ajaxSetup({
           	headers: {
               	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        	}
        });
		$("#start").click(function() {
			$("button").attr('disabled', 'disabled');
			$.get("{{ route('changePowerLevel', [$host, 'poweron']) }}", function(data) {
				if (data == "SUCCESS") {
					statusChange("online");
				} else if (data == "FAILED") {
					$("#statusModalTitle").text("Error");
					$("#statusModalText").text("Server could not be started.");
					$("#statusModal").modal();
				} else if (data == "ALREADY_STARTED") {
					$("#statusModalTitle").text("Error");
					$("#statusModalText").text("Server is already running.");
					$("#statusModal").modal();
				}
				$("button").removeAttr('disabled');
			});
		});
		$("#stop").click(function() {
			$("button").attr('disabled', 'disabled');
			$.get("{{ route('changePowerLevel', [$host, 'poweroffnicely']) }}", function(data) {
				if (data == "SUCCESS") {
					statusChange("offline");
				} else if (data == "FAILED") {
					$("#statusModalTitle").text("Error");
					$("#statusModalText").text("Server could not be stopped.");
					$("#statusModal").modal();
				} else if (data == "ALREADY_STOPPED") {
					$("#statusModalTitle").text("Error");
					$("#statusModalText").text("Server is already offline.");
					$("#statusModal").modal();
				}
				$("button").removeAttr('disabled');
			});
		});
		$("#kill").click(function() {
			$("button").attr('disabled', 'disabled');
			$.get("{{ route('changePowerLevel', [$host, 'poweroffforced']) }}", function(data) {
				if (data == "SUCCESS") {
					statusChange("offline");
				} else if (data == "FAILED") {
					$("#statusModalTitle").text("Fatal error");
					$("#statusModalText").text("Server could not be killed.");
					$("#statusModal").modal();
				} else if (data == "ALREADY_STOPPED") {
					$("#statusModalTitle").text("Error");
					$("#statusModalText").text("Server is already offline.");
					$("#statusModal").modal();
				}
				$("button").removeAttr('disabled');
			});
		});
		$("#cmd").on('keyup', function (e) {
    		if (e.keyCode == 13) {
    			$("#submitCmd").click();
    		}
    	});
		$("#submitCmd").click(function() {
			var CSRF_TOKEN = $("meta[name='csrf-token']").attr("content");
			$.post( "{{ route('serverCmd', [$host]) }}", { cmd: $("#cmd").val(), _token: CSRF_TOKEN }).done(function( data ) {
    			$("#cmd").val("");
  			});
		});
		$("#toggleAutoScroll").click(function() {
			if ($("#toggleAutoScroll").html() == "Enable autoscroll") {
				$("#toggleAutoScroll").html('Disable autoscroll');
			} else {
				$("#toggleAutoScroll").html('Enable autoscroll');
			}
		});
	});
</script>
@endsection
