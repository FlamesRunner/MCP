<?php
	DEFINE ("API_KEY", "qnpDJWILjpb9ScJPCnGTxNH4uPdLi4Uppmobo4SOsjCt8iItW9dQ8rKoHyL6y7TX");
	DEFINE ("MC_PASS", "GPgLCcXrHXmiGLvXCXCVOkRRaSODuT5f3yqr34DFdZ5O8Uf0AU33jcClnCUn86Y7");
        if ($_GET["k"] !== API_KEY) {
                die("INVALID_KEY");
        }

        function parseMinecraftColors($string) {
                $string = utf8_decode(htmlspecialchars($string, ENT_QUOTES, "UTF-8"));
                $string = preg_replace('/\xA7([0-9a-f])/i', '<span class="mc-color mc-$1">', $string, -1, $count) . str_repeat("</span>", $count);
                return utf8_encode(preg_replace('/\xA7([k-or])/i', '<span class="mc-$1">', $string, -1, $count) . str_repeat("</span>", $count));
        }

        function isServerOnline() {
                $resp = shell_exec('TERM=xterm screen -list | grep "No Sockets found"');
                return empty($resp);
        }

        switch($_GET["act"]) {
                case "validate":
                        echo "SUCCESS";
                        break;
                case "mcpass":
                        echo MC_PASS;
                        break;
                case "online":
                        echo isServerOnline() ? "Online" : "Offline";
                        break;
                case "ram":
                        $free = shell_exec('free');
                        $free = (string)trim($free);
                        $free_arr = explode("\n", $free);
                        $mem = explode(" ", $free_arr[1]);
                        $mem = array_filter($mem);
                        $mem = array_merge($mem);
                        echo round($mem[2]/$mem[1]*100);
                        break;
                case "cpu":
                        $command = "cat /proc/cpuinfo | grep processor | wc -l";
                        $cores = (int) shell_exec($command);
                        $load = sys_getloadavg()[0];
                        echo (float) ($load / $cores) * 100;
                        break;
                case "rawlog":
                        if (!file_exists('server/files/logs/latest.log')) {
                                echo "Nothing to see here...";
                        } else {
                                $c = parseMinecraftColors(shell_exec("tail -n 100 server/files/logs/latest.log"));
                                echo "$c";
                        }
                        break;
                case "start":
                        if (isServerOnline()) {
                                echo "SERVER_ALREADY_ONLINE";
                        } else {
                                exec('TERM=xterm screen -S mcserver -d -m "./start.sh"');
                                echo "SUCCESS";
                        }
                        break;
                case "exec":
                        if (isServerOnline()) {
                                exec('TERM=xterm screen -S mcserver -X eval \'stuff "' . escapeshellarg($_GET["cmd"]) . '\015"\'');
                                echo "SUCCESS";
                        } else {
                                echo "SERVER_OFFLINE";
                        }
                        break;
                case "gracefulstop":
                        if (isServerOnline()) {
                                exec('TERM=xterm screen -S mcserver -X eval \'stuff "stop\015"\'');
                                echo "SUCCESS";
                        } else {
                                echo "SERVER_OFFLINE";
                        }
                        break;
                case "forcestop":
                        if (isServerOnline()) {
                                exec('TERM=xterm screen -X -S mcserver quit');
                                echo "SUCCESS";
                        } else {
                                echo "SERVER_OFFLINE";
                        }
                        break;
                case "getram":
                        $current = file_get_contents("start.sh");
                        preg_match_all('^(java -Xmx)(\d+)(M -jar server.jar)^', $current, $out, PREG_PATTERN_ORDER);
                        echo $out[2][0];
                        break;
                case "setram":
                        if (empty($_GET["ram"])) {
                                echo "RAM_NOT_SPECIFIED";
                        } else if (!ctype_digit($_GET["ram"])) {
                                echo "RAM_INVALID";
                        } else {
                                $txt = file_get_contents('start.sh');
                                $newText = preg_replace('^(\\d+)^', $_GET["ram"], $txt, -1, $count);
                                file_put_contents('start.sh', $newText);
                                echo "SUCCESS";
                        }
                        break;
		case "getport":
			if (!file_exists("server/files/server.properties")) {
				echo "25565";
			} else {
				$current = file_get_contents("server/files/server.properties");
				preg_match_all('/(server-port=)(\d+)/', $current, $out, PREG_PATTERN_ORDER);
				echo $out[2][0];
			}
			break;
		case "setport":
			if (empty($_GET["port"])) {
				echo "PORT_NOT_SPECIFIED";
			} else if (!ctype_digit($_GET["port"])) {
				echo "PORT_INVALID";
			} else if ($_GET["port"] <= 1000 || $_GET["port"] >= 65535) {
				echo "PORT_RANGE_INVALID";
			} else if (!file_exists("server/files/server.properties")) {
				echo "PROPERTIES_FILE_NOT_FOUND";
			} else {
                                $txt = file_get_contents('server/files/server.properties');
                                $newText = preg_replace('/(server-port=)\d+/', "server-port=" . trim($_GET["port"]), $txt, -1, $count);
                                $newText = preg_replace('/(query.port=)\d+/', "query.port=" . trim($_GET["port"]), $newText, -1, $count);
                                file_put_contents('server/files/server.properties', $newText);
                                echo "SUCCESS";
			}
			break;
                default:
                        echo "n/a";
                        break;
        }

?>

