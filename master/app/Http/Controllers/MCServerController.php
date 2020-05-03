<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use \xPaw\MinecraftPing;
use \xPaw\MinecraftPingException;
use App\MCServers;
use Validator;

ini_set('default_socket_timeout', 10);

class MCServerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addServer (Request $request) {
        $success = true;
        $validatedData = $request->validate([
            'host' => 'required|max:128|min:7',
            'apikey' => 'required|min:64|alpha_num'
        ]);

        $hosts = MCServers::where('host', $request->input('host'));
        if ($hosts->count() > 0) {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'This host has already been registered.');
            $success = false;
        }

        if (!$success) return redirect('/servers');

        $validated = true;
        try {
            $req = file_get_contents("http://" . $request->input('host') . "/api.php?k=" . $request->input('apikey') . "&act=validate");
            if (empty($req) || trim($req) !== "SUCCESS") {
                $validated = false;
           }
        } catch (\Exception $e) {
            $validated = false;
        }

        if ($validated) {
            $srv = new MCServers;
            $srv->email = auth()->user()->email;
            $srv->host = $request->input('host');
            $srv->apikey = $request->input('apikey');
            $srv->save();
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'The server was added successfully.');
        } else {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'The API key could not be validated. Please try again.');
        }

        return redirect(route("listServers"));
    }

    public function serverCmd ($host, Request $request) {
        $hosts = MCServers::where('host', $host);
        if ($hosts->where('email', auth()->user()->email)->count() == 0) {
          $request->session()->flash('message.level', 'danger');
          $request->session()->flash('message.content', 'Access denied.');
          return redirect(route('listServers'));
        }
        $serverObject = $hosts->first();
        $apikey = $serverObject->apikey;
        $cmd = $request->input("cmd");
        $contents = "";
        try {
            $contents = file_get_contents("http://" . $host . "/api.php?k=" . $apikey . "&act=exec&cmd=" . urlencode($cmd));
        } catch (\Exception $ex) {
            $contents = "Failed to send command";
        }
        return (trim($contents) == "SUCCESS") ? "SUCCESS" : "FAILED";
    }

    public function consoleLog ($host, Request $request) {
        $hosts = MCServers::where('host', $host);      
        if ($hosts->where('email', auth()->user()->email)->count() == 0) {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Access denied.');
            return redirect(route('listServers'));
        }
        $contents = "";
        $serverObject = $hosts->first();
        $apikey = $serverObject->apikey;
        try {
            $contents = file_get_contents("http://" . $host . "/api.php?k=" . $apikey . "&act=rawlog");
        } catch (\Exception $ex) {
            $contents = "Failed to load";
        }
        return trim("$contents");
    }

    public function serverStatus ($host, Request $request) {
        $hosts = MCServers::where('host', $host);      
        if ($hosts->where('email', auth()->user()->email)->count() == 0) {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Access denied.');
            return redirect(route('listServers'));
        }
        $contents = "";
        $serverObject = $hosts->first();
        $apikey = $serverObject->apikey;

        $ramUsage = "";
        $cpuUsage = "";
        $power = "";
        try {
            $ramUsage = @file_get_contents("http://" . $host . "/api.php?k=" . $apikey . "&act=ram");
            $cpuUsage = @file_get_contents("http://" . $host . "/api.php?k=" . $apikey . "&act=cpu");
            $power = @file_get_contents("http://" . $host . "/api.php?k=" . $apikey . "&act=online");
        } catch (\Exception $ex) {
            $ramUsage = "Unknown";
            $cpuUsage = "Unknown";
            $power = "Unknown";
        }
        $ret = array("ram" => trim($ramUsage),
                     "cpu" => trim($cpuUsage),
                     "power" => trim($power));

        return json_encode($ret);
    }

    public function pingServer ($host, Request $request) {
       $hosts = MCServers::where('host', $host);
       if ($hosts->where('email', auth()->user()->email)->count() == 0) {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Access denied.');
            return redirect(route('listServers'));
        }
        try {
            $data = new MinecraftPing($host, 25565);
            return json_encode($data->Query());
        } catch (\Exception $e) {
            return "Unknown";
        }
    }

    public function serverSettings ($host, Request $request) {
       $hosts = MCServers::where('host', $host);
       if ($hosts->where('email', auth()->user()->email)->count() == 0) {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Access denied.');
            return redirect(route('listServers'));
        }
        $serverObject = $hosts->first();
        $apikey = $serverObject->apikey;
        try {
            $fp = @fsockopen($host, 80, $errno, $errstr, 3);
            $online = $fp!=false;
        } catch (\Exception $ex) {
            $online = false;
        }
        if (!$online) {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Server is offline.');
            return redirect(route('listServers'));
        }
        $ram = "";
        try {
            $ram = trim(@file_get_contents("http://" . $host . "/api.php?k=" . $apikey . "&act=getram"));
        } catch (\Exception $ex) {
            $ram = "0";
        }
        $port = "";
        try {
            $port = trim(@file_get_contents("http://" . $host . "/api.php?k=" . $apikey . "&act=getport"));
            if ($port == "no_port_set") {
                $port = "NOT_SET";
            } else if ($port == "SERVER_PROPERTIES_NOT_SET") {
                $port = "NOT_SET";
            }
        } catch (\Exception $ex) {
            $port = "NOT_SET";
        }
        return view("serverSettings")->with('ram', $ram)->with('port', $port)->with('host', $host);
    }

    public function saveSettings ($host, Request $request) {
        $hosts = MCServers::where('host', $host);
        if ($hosts->where('email', auth()->user()->email)->count() == 0) {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Access denied.');
            return redirect(route('listServers'));
        }
        $serverObject = $hosts->first();
        $apikey = $serverObject->apikey;
        $sts_1_st = false;
        $sts_1 = "";
        $sts_2_st = false;
        $sts_2 = "";
        if (!ctype_digit($request->input('port')) && $request->input('port') !== "NOT_SET") {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Invalid port value.');
            return redirect(route('serverSettings', [$host]));
        }

        if (!ctype_digit($request->input('ram'))) {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Invalid RAM value.');
            return redirect(route('serverSettings', [$host]));
        }
        try {
            $sts_1 = file_get_contents("http://" . $host . "/api.php?k=" . $apikey . "&act=setram&ram=" . $request->input('ram'));
        } catch (\Exception $ex) {
            $sts_1 = "FAILED";
        }
        $sts_1_st = (trim($sts_1) == "SUCCESS");

        if (trim($request->input('port')) == "NOT_SET") {
            $sts_2_st = true;
        } else {
            try {
                $sts_2 = file_get_contents("http://" . $host . "/api.php?k=" . $apikey . "&act=setport&port=" . $request->input('port'));
            } catch (\Exception $ex) {
                $sts_2 = "FAILED";
            }
            $sts_2_st = (trim($sts_2) == "SUCCESS");
        }
        if ($sts_1_st && $sts_2_st) {
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Server settings were saved.');
        } else if (trim($sts_2) == "PROPERTIES_FILE_NOT_FOUND") {
            $request->session()->flash('message.level', 'warning');
            $request->session()->flash('message.content', 'Before changing the port, you need to start the server at least once.');
	} else {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'One or more settings could not be saved.');
        }
        
        return redirect(route('serverSettings', [$host]));
    }

    public function manageServerPage ($host, Request $request) {
       $hosts = MCServers::where('host', $host);
       if ($hosts->where('email', auth()->user()->email)->count() == 0) {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Access denied.');
            return redirect(route('listServers'));
        }
        $serverObject = $hosts->first();
        $apikey = $serverObject->apikey;
        $online = false;
        try {
            $fp = @fsockopen($host, 80, $errno, $errstr, 3);
            $online = $fp!=false;
        } catch (\Exception $ex) {
            $online = false;
        }
        if (!$online) {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Server is offline.');
            return redirect(route('listServers'));
        }
        return view('manageServer', ['host' => $host]);
    }

    public function changePowerLevel ($host, $status, Request $request) {
        $hosts = MCServers::where('host', $host);
        if ($hosts->where('email', auth()->user()->email)->count() == 0) {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Access denied.');
            return redirect(route('listServers'));
        }
        $serverObject = $hosts->first();
        $apikey = $serverObject->apikey;
        switch ($status) {
            case "poweron":
                $stu = "SUCCESS";
                try {
                    $stu = trim(file_get_contents("http://" . $host . "/api.php?k=" . $apikey . "&act=start"));
                } catch (\Exception $ex) {
                    $stu = "FAILED";
                }
                if (trim($stu) == "SERVER_ALREADY_ONLINE") $stu = "ALREADY_STARTED";
                echo $stu;
            break;
            case "poweroffnicely":
                $stu = "SUCCESS";
                try {
                    $stu = trim(file_get_contents("http://" . $host . "/api.php?k=" . $apikey . "&act=gracefulstop"));
                } catch (\Exception $ex) {
                    $stu = "FAILED";
                }
                if (trim($stu) == "SERVER_OFFLINE") $stu = "ALREADY_STOPPED";
                echo $stu;
                break;
            case "poweroffforced":
              $stu = "SUCCESS";
              try {
                  $stu = trim(file_get_contents("http://" . $host . "/api.php?k=" . $apikey . "&act=forcestop"));
              } catch (\Exception $ex) {
                  $stu = "FAILED";
              }
              if (trim($stu) == "SERVER_OFFLINE") $stu = "ALREADY_STOPPED";
              echo $stu;
              break;
        }
    }

    public function fileManager ($host, Request $request) {
       $hosts = MCServers::where('host', $host);
       if ($hosts->where('email', auth()->user()->email)->count() == 0) {
          $request->session()->flash('message.level', 'danger');
          $request->session()->flash('message.content', 'Access denied.');
          return redirect(route('listServers'));
        }
        $serverObject = $hosts->first();
        $apikey = $serverObject->apikey;
        $pass = "";
        try {
            $pass = file_get_contents("http://" . $host . "/api.php?k=" . $apikey . "&act=mcpass");
        } catch (\Exception $ex) {
            $pass = "FAILED";
        }
        if ($pass == "FAILED") return redirect(route("manageServerPage", [$host]));
        session_start();
        $_SESSION["username"] = "minecraft";
        $_SESSION["password"] = $pass;
        $_SESSION["host"] = $host;
        return redirect("/filemanager/index.php?state=browse&state2=main");
    }

    public function deleteServer (Request $request) {
        $success = true;
        $validatedData = $request->validate([
            'host' => 'required|max:128|min:1',
        ]);
        $hosts = MCServers::where('host', $request->input('host'));
        if ($hosts->where('email', auth()->user()->email)->count() == 0) {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Either the host is invalid or does not belong to you.');
            $success = false;
        }
        if (!$success) return redirect('/servers');
        $hosts->delete();
        return redirect(route("listServers"));
    }

    public function listServers () {
        $myServers = MCServers::where('email', auth()->user()->email);
        $servers = $myServers->get();
        return view('servers')->with('servers', $servers);
    }

    public function addServerPage() {
        return view('serverAddPage');
    }

}
