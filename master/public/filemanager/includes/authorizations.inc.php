<?php

//   -------------------------------------------------------------------------------
//  |                  net2ftp: a web based FTP client                              |
//  |              Copyright (c) 2003-2017 by David Gartner                         |
//  |                                                                               |
//  | This program is free software; you can redistribute it and/or                 |
//  | modify it under the terms of the GNU General Public License                   |
//  | as published by the Free Software Foundation; either version 2                |
//  | of the License, or (at your option) any later version.                        |
//  |                                                                               |
//   -------------------------------------------------------------------------------




// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function encryptPassword($password) {

// --------------
// This function encrypts the FTP password
// --------------

// -------------------------------------------------------------------------
// Global variables and settings
// -------------------------------------------------------------------------
	global $net2ftp_settings;

// -------------------------------------------------------------------------
// If mcrypt libraries are available, encrypt the password with the Stone PHP SafeCrypt library
// http://blog.sc.tri-bit.com/archives/101
// -------------------------------------------------------------------------
//	if (function_exists("mcrypt_module_open") == true) {
//		$packed = PackCrypt($password, DEFAULT_MD5_SALT);
//		if ($packed["success"] == true) { return $packed["output"]; }
//		else { 
//			setErrorVars(false, "An error occured when trying to encrypt the password: " . $packed["reason"], debug_backtrace(), __FILE__, __LINE__);		
//		}
//	}
// -------------------------------------------------------------------------
// Else, XOR it with a random string
// -------------------------------------------------------------------------
//	else {
		$password_encrypted = "";
		$encryption_string = sha1($net2ftp_settings["encryption_string"]);
		if (strlen($encryption_string) % 2 == 1) { // we need even number of characters
			$encryption_string .= $encryption_string{0};
		}
		for ($i=0; $i < strlen($password); $i++) { // encrypts one character - two bytes at once
			$password_encrypted .= sprintf("%02X", hexdec(substr($encryption_string, 2*$i % strlen($encryption_string), 2)) ^ ord($password{$i}));
		}
		return $password_encrypted;
//	}

} // End function encryptPassword

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function decryptPassword($password_encrypted) {

// --------------
// This function decrypts the FTP password
// --------------

// -------------------------------------------------------------------------
// Global variables and settings
// -------------------------------------------------------------------------
	global $net2ftp_settings;

// -------------------------------------------------------------------------
// If mcrypt libraries are available, encrypt the password with the Stone PHP SafeCrypt library
// http://blog.sc.tri-bit.com/archives/101
// -------------------------------------------------------------------------
//	if (function_exists("mcrypt_module_open") == true) {
//		$unpacked = UnpackCrypt($password_encrypted, DEFAULT_MD5_SALT);
//		if ($unpacked["success"] == true) { return $unpacked["output"]; }
//		else { 
//			setErrorVars(false, "An error occured when trying to decrypt the password: " . $unpacked["reason"], debug_backtrace(), __FILE__, __LINE__);		
//		}
//	}

// -------------------------------------------------------------------------
// Else, XOR it with a random string
// -------------------------------------------------------------------------
//	else {
		$password = "";
		$encryption_string = sha1($net2ftp_settings["encryption_string"]);
		if (strlen($encryption_string) % 2 == 1) { // we need even number of characters
			$encryption_string .= $encryption_string{0};
		}
		for ($i=0; $i < strlen($password_encrypted); $i += 2) { // decrypts two bytes - one character at once
			$password .= chr(hexdec(substr($encryption_string, $i % strlen($encryption_string), 2)) ^ hexdec(substr($password_encrypted, $i, 2)));
		}
		return $password;
//	}

} // End function decryptPassword

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function checkIPinNetwork($ip, $network) {

// ----------
// This function checks if an IP address is part of a network
// If yes, it returns true; if no, it returns false
//
// The network's IP address range must be one of these notations:
// - Single IP         (example: 192.168.1.1)
// - IP from-to        (example: 192.168.1.1-192.168.1.10)
// - CIDR notation     (example: 192.168.1.0/30 or 192.168.1/30)
// ----------

	$ip = trim($ip);
	$network = trim($network);

// network is in the format 192.168.1.1-192.168.1.10
	$d = strpos($network,"-");
	if ($d !== false) {
		$from = ip2long(trim(substr($network,0,$d)));
		$to = ip2long(trim(substr($network,$d+1)));
		$ip = ip2long($ip);
		return ($ip >= $from and $ip <= $to);
	}

// network is in the format 192.168.1.0/30 or 192.168.1/30
	$d = strpos($network,"/");
	if ($d !== false) {
		$ip_arr = explode("/", $network);
		if (!preg_match("@\d*\.\d*\.\d*\.\d*@", $ip_arr[0], $matches)){
			$ip_arr[0] .= ".0"; // To handle networks like 192.168.1/30 (instead of 192.168.1.0/30)
		}
		$network_long = ip2long($ip_arr[0]);
		$x = ip2long($ip_arr[1]);
		$mask = long2ip($x) == $ip_arr[1] ? $x : (0xffffffff << (32 - $ip_arr[1]));
		$ip_long = ip2long($ip);
		return ($ip_long & $mask) == ($network_long & $mask);
	}

// network is a simple IP address
	if ($ip == $network) { return true; }
	else { return false; }

} // End function checkIPinNetwork

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function printLoginInfo() {

// --------------
// This function prints the ftpserver, username and login information
// --------------

	global $net2ftp_globals, $net2ftp_settings;

	echo "<input type=\"hidden\" name=\"skin\"               value=\"" . htmlEncode2($net2ftp_globals["skin"]) . "\" />\n";
	echo "<input type=\"hidden\" name=\"language\"           value=\"" . htmlEncode2($net2ftp_globals["language"]) . "\" />\n";
	echo "<input type=\"hidden\" name=\"protocol\"           value=\"" . htmlEncode2($net2ftp_globals["protocol"]) . "\" />\n";
	echo "<input type=\"hidden\" name=\"ftpserver\"          value=\"" . htmlEncode2($net2ftp_globals["ftpserver"]) . "\" />\n";
	echo "<input type=\"hidden\" name=\"ftpserverport\"      value=\"" . htmlEncode2($net2ftp_globals["ftpserverport"]) . "\" />\n";
	echo "<input type=\"hidden\" name=\"username\"           value=\"" . htmlEncode2($net2ftp_globals["username"]) . "\" />\n";
	echo "<input type=\"hidden\" name=\"password_encrypted\" value=\"" . htmlEncode2($net2ftp_globals["password_encrypted"]) . "\" />\n";
	echo "<input type=\"hidden\" name=\"sshfingerprint\"     value=\"" . htmlEncode2($net2ftp_globals["sshfingerprint"]) . "\" />\n";
	echo "<input type=\"hidden\" name=\"ftpmode\"            value=\"" . htmlEncode2($net2ftp_globals["ftpmode"]) . "\" />\n";
	echo "<input type=\"hidden\" name=\"passivemode\"        value=\"" . htmlEncode2($net2ftp_globals["passivemode"]) . "\" />\n";
	echo "<input type=\"hidden\" name=\"viewmode\"           value=\"" . htmlEncode2($net2ftp_globals["viewmode"]) . "\" />\n";
	echo "<input type=\"hidden\" name=\"sort\"               value=\"" . htmlEncode2($net2ftp_globals["sort"]) . "\" />\n";
	echo "<input type=\"hidden\" name=\"sortorder\"          value=\"" . htmlEncode2($net2ftp_globals["sortorder"]) . "\" />\n";
	echo "<input type=\"hidden\" name=\"consent_necessary\"            value=\"" . htmlEncode2($net2ftp_globals["consent_necessary"]) . "\" />\n";
	echo "<input type=\"hidden\" name=\"consent_preferences\"          value=\"" . htmlEncode2($net2ftp_globals["consent_preferences"]) . "\" />\n";
	echo "<input type=\"hidden\" name=\"consent_statistics\"           value=\"" . htmlEncode2($net2ftp_globals["consent_statistics"]) . "\" />\n";
	echo "<input type=\"hidden\" name=\"consent_personalized_ads\"     value=\"" . htmlEncode2($net2ftp_globals["consent_personalized_ads"]) . "\" />\n";
	echo "<input type=\"hidden\" name=\"consent_nonpersonalized_ads\"  value=\"" . htmlEncode2($net2ftp_globals["consent_nonpersonalized_ads"]) . "\" />\n";
	echo "<input type=\"hidden\" name=\"user_email\"                   value=\"" . htmlEncode2($net2ftp_globals["user_email"]) . "\" />\n";
	for ($i=1; $i<=10; $i++) {
		if (isset($net2ftp_settings["privacy_policy_" . $i]) && $net2ftp_settings["privacy_policy_" . $i] != "") {
			echo "<input type=\"hidden\" name=\"privacy" . $i . "\"            value=\"" . htmlEncode2($net2ftp_globals["privacy" . $i]) . "\" />\n";
		}
	} // end for

} // End function printLoginInfo

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************






// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function printLoginInfo_javascript() {

// --------------
// This function prints the ftpserver, username and login information -- for javascript input
// --------------

	global $net2ftp_globals, $net2ftp_settings;

	echo "	d.writeln('<input type=\"hidden\" name=\"skin\"               value=\"" . javascriptEncode2($net2ftp_globals["skin"])               . "\" />');\n";
	echo "	d.writeln('<input type=\"hidden\" name=\"language\"           value=\"" . javascriptEncode2($net2ftp_globals["language"])           . "\" />');\n";
	echo "	d.writeln('<input type=\"hidden\" name=\"protocol\"           value=\"" . javascriptEncode2($net2ftp_globals["protocol"])           . "\" />');\n";
	echo "	d.writeln('<input type=\"hidden\" name=\"ftpserver\"          value=\"" . javascriptEncode2($net2ftp_globals["ftpserver"])          . "\" />');\n";
	echo "	d.writeln('<input type=\"hidden\" name=\"ftpserverport\"      value=\"" . javascriptEncode2($net2ftp_globals["ftpserverport"])      . "\" />');\n";
	echo "	d.writeln('<input type=\"hidden\" name=\"username\"           value=\"" . javascriptEncode2($net2ftp_globals["username"])           . "\" />');\n";
	echo "	d.writeln('<input type=\"hidden\" name=\"password_encrypted\" value=\"" . javascriptEncode2($net2ftp_globals["password_encrypted"]) . "\" />');\n";
	echo "	d.writeln('<input type=\"hidden\" name=\"sshfingerprint\"     value=\"" . javascriptEncode2($net2ftp_globals["sshfingerprint"])     . "\" />');\n";
	echo "	d.writeln('<input type=\"hidden\" name=\"ftpmode\"            value=\"" . javascriptEncode2($net2ftp_globals["ftpmode"])            . "\" />');\n";
	echo "	d.writeln('<input type=\"hidden\" name=\"passivemode\"        value=\"" . javascriptEncode2($net2ftp_globals["passivemode"])        . "\" />');\n";
	echo "	d.writeln('<input type=\"hidden\" name=\"viewmode\"           value=\"" . javascriptEncode2($net2ftp_globals["viewmode"])           . "\" />');\n";
	echo "	d.writeln('<input type=\"hidden\" name=\"sort\"               value=\"" . javascriptEncode2($net2ftp_globals["sort"])               . "\" />');\n";
	echo "	d.writeln('<input type=\"hidden\" name=\"sortorder\"          value=\"" . javascriptEncode2($net2ftp_globals["sortorder"])          . "\" />');\n";
	echo "	d.writeln('<input type=\"hidden\" name=\"consent_necessary\"           value=\"" . javascriptEncode2($net2ftp_globals["consent_necessary"])           . "\" />');\n";
	echo "	d.writeln('<input type=\"hidden\" name=\"consent_preferences\"         value=\"" . javascriptEncode2($net2ftp_globals["consent_preferences"])         . "\" />');\n";
	echo "	d.writeln('<input type=\"hidden\" name=\"consent_statistics\"          value=\"" . javascriptEncode2($net2ftp_globals["consent_statistics"])          . "\" />');\n";
	echo "	d.writeln('<input type=\"hidden\" name=\"consent_personalized_ads\"    value=\"" . javascriptEncode2($net2ftp_globals["consent_personalized_ads"])    . "\" />');\n";
	echo "	d.writeln('<input type=\"hidden\" name=\"consent_nonpersonalized_ads\" value=\"" . javascriptEncode2($net2ftp_globals["consent_nonpersonalized_ads"]) . "\" />');\n";
	echo "	d.writeln('<input type=\"hidden\" name=\"user_email\"                  value=\"" . javascriptEncode2($net2ftp_globals["user_email"])                  . "\" />');\n";
	for ($i=1; $i<=10; $i++) {
		if (isset($net2ftp_settings["privacy_policy_" . $i]) && $net2ftp_settings["privacy_policy_" . $i] != "") {
			echo "	d.writeln('<input type=\"hidden\" name=\"privacy" . $i . "\"           value=\"" . javascriptEncode2($net2ftp_globals["privacy" . $i])                . "\" />');\n";
		}
	} // end for


} // End function printLoginInfo_javascript

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************






// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function printPHP_SELF($case) {

// --------------
// This function prints $PHP_SELF, the name of the script itself
// --------------

// -------------------------------------------------------------------------
// Global variables and settings
// -------------------------------------------------------------------------
	global $net2ftp_globals, $net2ftp_settings;

	$protocol           = urlEncode2($net2ftp_globals["protocol"]);
	$ftpserver          = urlEncode2($net2ftp_globals["ftpserver"]);
	$ftpserverport      = urlEncode2($net2ftp_globals["ftpserverport"]);
	$username           = urlEncode2($net2ftp_globals["username"]);
	$password_encrypted = urlEncode2($net2ftp_globals["password_encrypted"]);
	$directory_html     = urlEncode2($net2ftp_globals["directory"]);
	$entry_html         = urlEncode2($net2ftp_globals["entry"]);
	$skin               = urlEncode2($net2ftp_globals["skin"]);
	$language           = urlEncode2($net2ftp_globals["language"]);
	$sshfingerprint     = urlEncode2($net2ftp_globals["sshfingerprint"]);
	$ftpmode            = urlEncode2($net2ftp_globals["ftpmode"]);
	$passivemode        = urlEncode2($net2ftp_globals["passivemode"]);
	$viewmode           = urlEncode2($net2ftp_globals["viewmode"]);
	$sort               = urlEncode2($net2ftp_globals["sort"]);
	$sortorder          = urlEncode2($net2ftp_globals["sortorder"]);
	$state_html         = urlEncode2($net2ftp_globals["state"]);
	$state2_html        = urlEncode2($net2ftp_globals["state2"]);
	$user_email_html    = urlEncode2($net2ftp_globals["user_email"]);
	$consent_necessary           = urlEncode2($net2ftp_globals["consent_necessary"]);
	$consent_preferences         = urlEncode2($net2ftp_globals["consent_preferences"]);
	$consent_statistics          = urlEncode2($net2ftp_globals["consent_statistics  "]);
	$consent_personalized_ads    = urlEncode2($net2ftp_globals["consent_personalized_ads"]);
	$consent_nonpersonalized_ads = urlEncode2($net2ftp_globals["consent_nonpersonalized_ads"]);
	$privacy_full_html  = "";
	for ($i=1; $i<=10; $i++) {
		if (isset($net2ftp_settings["privacy_policy_" . $i]) && $net2ftp_settings["privacy_policy_" . $i] != "") {
			$privacy_full_html .= "&amp;privacy" . $i . "=" . htmlEncode2($net2ftp_globals["privacy" . $i]);
		}
	} // end for

// From /includes/registerglobals.inc.php
	$URL = $net2ftp_globals["action_url"];

// If the URL already contains parameters (?param1=value1&amp;param2=value2...), append &amp;
// If not, append a ?
	if (strpos($URL, "?") !== false) { $URL .= "&amp;"; }
	else                             { $URL .= "?"; }

// Append further parameters
	if     ($case == "actions") {
		$URL .= "protocol=$protocol&amp;ftpserver=$ftpserver&amp;ftpserverport=$ftpserverport&amp;username=$username&amp;skin=$skin&amp;language=$language&amp;sshfingerprint=$sshfingerprint&amp;ftpmode=$ftpmode&amp;passivemode=$passivemode&amp;viewmode=$viewmode&amp;sort=$sort&amp;sortorder=$sortorder" . $privacy_full_html;
	}
// Bookmark with password
// Until version 1.1: go straight to the bookmarked state (e.g. Browse, Edit, etc)
// As of version 1.2: always show login_small form, either with or without password filled in; captcha is needed to block robots 
	elseif ($case == "bookmark_withpw") {
//		$URL .= "protocol=$protocol&amp;amp;ftpserver=$ftpserver&amp;amp;ftpserverport=$ftpserverport&amp;amp;sshfingerprint=$sshfingerprint&amp;amp;username=$username&amp;amp;password_encrypted=$password_encrypted&amp;amp;language=$language&amp;amp;skin=$skin&amp;amp;ftpmode=$ftpmode&amp;amp;passivemode=$passivemode&amp;amp;viewmode=$viewmode&amp;amp;sort=$sort&amp;amp;sortorder=$sortorder&amp;amp;state=$state_html&amp;amp;state2=$state2_html&amp;amp;directory=$directory_html&amp;amp;entry=$entry_html";
		$URL .= "protocol=$protocol&amp;amp;ftpserver=$ftpserver&amp;amp;ftpserverport=$ftpserverport&amp;amp;sshfingerprint=$sshfingerprint&amp;amp;username=$username&amp;amp;password_encrypted=$password_encrypted&amp;amp;language=$language&amp;amp;skin=$skin&amp;amp;ftpmode=$ftpmode&amp;amp;passivemode=$passivemode&amp;amp;viewmode=$viewmode&amp;amp;sort=$sort&amp;amp;sortorder=$sortorder&amp;amp;state=login_small&amp;amp;state2=bookmark&amp;amp;go_to_state=$state_html&amp;amp;go_to_state2=$state2_html&amp;amp;directory=$directory_html&amp;amp;entry=$entry_html" . $privacy_full_html;
	}
// Bookmark without password and without SSH fingerprint: go first to the login_small state to enter the password and check the SSH fingerprint
	elseif ($case == "bookmark_withoutpw") {
		$URL .= "protocol=$protocol&amp;amp;ftpserver=$ftpserver&amp;amp;ftpserverport=$ftpserverport&amp;amp;sshfingerprint=$sshfingerprint&amp;amp;username=$username&amp;amp;language=$language&amp;amp;skin=$skin&amp;amp;ftpmode=$ftpmode&amp;amp;passivemode=$passivemode&amp;amp;viewmode=$viewmode&amp;amp;sort=$sort&amp;amp;sortorder=$sortorder&amp;amp;state=login_small&amp;amp;state2=bookmark&amp;amp;go_to_state=$state_html&amp;amp;go_to_state2=$state2_html&amp;amp;directory=$directory_html&amp;amp;entry=$entry_html" . $privacy_full_html;
	}
// Jupload java applet: the cookie information is added to the page using javascript (/skins/blue/jupload1.template.php)
	elseif ($case == "jupload") {
		$URL .= "protocol=$protocol&amp;ftpserver=$ftpserver&amp;ftpserverport=$ftpserverport&amp;sshfingerprint=$sshfingerprint&amp;username=$username&amp;language=$language&amp;skin=$skin&amp;ftpmode=$ftpmode&amp;passivemode=$passivemode&amp;directory=$directory_html&amp;state=jupload&amp;screen=2" . $privacy_full_html;
	}
	elseif ($case == "view") {
		$URL .= "protocol=$protocol&amp;ftpserver=$ftpserver&amp;ftpserverport=$ftpserverport&amp;sshfingerprint=$sshfingerprint&amp;username=$username&amp;language=$language&amp;skin=$skin&amp;ftpmode=$ftpmode&amp;passivemode=$passivemode&amp;viewmode=$viewmode&amp;sort=$sort&amp;sortorder=$sortorder&amp;state=$state_html&amp;state2=image&amp;directory=$directory_html&amp;entry=$entry_html" . $privacy_full_html;
	}
	elseif ($case == "createDirectoryTreeWindow") {
		$URL = $net2ftp_globals["application_rootdir_url"] . "/index.php";
	}
// Change skin
	elseif ($case == "defaultskin") {
		$URL .= "protocol=$protocol&amp;ftpserver=$ftpserver&amp;ftpserverport=$ftpserverport&amp;sshfingerprint=$sshfingerprint&amp;username=$username&amp;language=$language&amp;skin=" . $net2ftp_settings["default_skin"] . "&amp;ftpmode=$ftpmode&amp;passivemode=$passivemode&amp;viewmode=$viewmode&amp;sort=$sort&amp;sortorder=$sortorder&amp;state=$state_html&amp;state2=$state2_html&amp;directory=$directory_html&amp;entry=$entry_html" . $privacy_full_html;
	}
	return $URL;

} // End function printPHP_SELF

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function checkAuthorization($ftpserver, $ftpserverport, $directory, $username) {

// --------------
// This function checks if
// 1) the user is a real person using the captcha 
// 2) the user's country (derived from the user's IP address) in the list of banned countries
// 3) the user's IP address is in the database table of anonymizer services (VPN, proxy, Tor exits)
// 4) the user's IP address is in the list of allowed IP addresses
// 5) the user's IP address is in the list of banned IP addresses
// 6) the FTP server's country (derived from the FTP server's IP address) in the list of banned countries
// 7) the FTP server is in the list of those that may be accessed
// 8) the FTP server is in the list of those that may NOT be accessed
// 9) the FTP server port is in the allowed range
// 10) the directory is authorised: whether the current $directory name contains a banned keyword.
// 11) the privacy policies (checkboxes on the login screen) were accepted
// If all is OK, then the user may continue...
// --------------

// -------------------------------------------------------------------------
// Global variables
// -------------------------------------------------------------------------
	global $net2ftp_globals, $net2ftp_settings, $net2ftp_result, $_POST;


// -------------------------------------------------------------------------
// Connect to the database
// -------------------------------------------------------------------------
	if ($net2ftp_settings["use_database"] == "yes") {
		net2ftp_connect_db();
		if ($net2ftp_result["success"] == false) { return false; }
	}


// -------------------------------------------------------------------------
// Convert the user's IP address to a number ($user_ip_number)
// Look up the FTP server's IP address and convert it to a number too ($ftpserver_ip_number)
// -------------------------------------------------------------------------

// ----------------------------
// Determine user's IP
// ----------------------------
	$user_ipaddress_number = Dot2LongIP($net2ftp_globals["REMOTE_ADDR"]);

// ----------------------------
// Determine FTP server's IP
// Note that $ftpserver can be a hostname or an IP address
// ----------------------------
	if ($ftpserver != "") {
		$ftpserver_filtered = filter_var($ftpserver, FILTER_VALIDATE_IP);
// FTP server is an IP address already
		if ($ftpserver_filtered == $ftpserver) {
			$ftpserver_ipaddress_number = Dot2LongIP($ftpserver);
			$net2ftp_globals["ftpserver_ipaddress"] = $ftpserver;
		}
// FTP server is a hostname
		else {
			$ftpserver_clean = trim($ftpserver . '.');
			$ftpserver_ipaddress = gethostbyname($ftpserver_clean);
// Set ftpserver_ip to blank if IP address lookup failed
			if ($ftpserver_ipaddress == $ftpserver_clean) { 
				$ftpserver_ipaddress = ""; 
				$ftpserver_ipaddress_number = "";
				$net2ftp_globals["ftpserver_ipaddress"] = "";
			} 	
			else {
				$ftpserver_ipaddress_number = Dot2LongIP($ftpserver_ipaddress);
				$net2ftp_globals["ftpserver_ipaddress"] = $ftpserver_ipaddress;
			}
		}
	} // end if ($ftpserver != "")
	else {
		$net2ftp_globals["ftpserver_ipaddress"] = "";
		$net2ftp_globals["ftpserver_country"] = "";
	}

// -------------------------------------------------------------------------
// 1) Check if the user is a real person using the captcha 
// -------------------------------------------------------------------------

	if ($net2ftp_settings["use_captcha"] == "yes" && $net2ftp_globals["state"] != "serverfingerprint") {
// User comes from login screen; send request to Google
//     https://www.kaplankomputing.com/blog/tutorials/recaptcha-php-demo-tutorial/
// How to solve file_get_contents errors and setup openssl
// https://stackoverflow.com/questions/26148701/file-get-contents-ssl-operation-failed-with-code-1-and-more
// On Ubuntu 16.04, this worked: prioritize IPv4 over IPv6 in /etc/gai.conf

// When user submits login form and goes to browse screen, send captcha info to Google
// Skip this when user reloads browse screen after logging in, to avoid captcha errors (Google returns error if captcha is sent a 2nd time)
		if (isset($_POST["g-recaptcha-response"]) == true && (isset($_SESSION["captcha"]) == false || $_SESSION["captcha"] != "OK")) {
			$response = $_POST["g-recaptcha-response"];
			$url = 'https://www.google.com/recaptcha/api/siteverify';
			$data = array(
				'secret' => $net2ftp_settings["recaptcha_secretkey"],
				'response' => $response
			);
			$options = array(
				'http' => array(
					'header' => 'Content-Type: application/x-www-form-urlencoded\r\n',
					'method' => 'POST',
					'content' => http_build_query($data)
				)
			);
			$context = stream_context_create($options);
			$verify  = file_get_contents($url, false, $context);
			if ($verify === false) {
				$errormessage = __("Connection from net2ftp server to Google captcha server failed");
				setErrorVars(false, $errormessage, debug_backtrace(), __FILE__, __LINE__);
				return false;
			} 
			$captcha_success = json_decode($verify);
			if ($captcha_success->success == false) {
				$_SESSION["captcha"] = "Error";
				$errormessage = __("Captcha check failed on the login screen. Please return to the login screen and tick the 'I'm not a robot' checkbox before clicking on the 'Login' button.");
				setErrorVars(false, $errormessage, debug_backtrace(), __FILE__, __LINE__);
				return false;
			} 
			else if ($captcha_success->success == true) {
				$_SESSION["captcha"] = "OK";
			}
		}

// User comes from another screen
		else {
			if ($_SESSION["captcha"] != "OK") {
				$errormessage = __("Captcha check failed in the session. Please return to the login screen and tick the 'I'm not a robot' checkbox before clicking on the 'Login' button.");
				setErrorVars(false, $errormessage, debug_backtrace(), __FILE__, __LINE__);
				return false;
			} 
		}
	} // end if ($net2ftp_settings["use_captcha"] == "yes") 


// -------------------------------------------------------------------------
// 2) Check if the user's country (derived from the user's IP address) in the list of banned countries
// -------------------------------------------------------------------------

	if ($net2ftp_settings["use_geoblocking"] == "yes") {

// Determine the user's country based on his IP address
		$sqlquery2 = "SELECT * FROM ip2location_db1 WHERE ip_to >= $user_ipaddress_number LIMIT 1;";
		$result2   = mysqli_query($net2ftp_globals["mysqli_link"], "$sqlquery2");
		if ($result2 == false) { 
			setErrorVars(false, "Unable to execute SQL SELECT query (checkAuthorization > sqlquery2) <br /> $sqlquery2", debug_backtrace(), __FILE__, __LINE__);
			return false; 
		}

		$resultRow2 = mysqli_fetch_object($result2); 
		$user_country_code = $resultRow2->country_code;
		$user_country_name = $resultRow2->country_name;
		$net2ftp_globals["user_country"] = $user_country_code;

		mysqli_free_result($result2);

// Check if user's country is allowed or blocked
		for ($i = 1; $i <= sizeof($net2ftp_settings["geoblock"]); $i++) {
			if ($user_country_code == $net2ftp_settings["geoblock"][$i]) { 
				setErrorVars(false, "
The European Union's \"General Data Protection Regulation\" (GDPR) has taken effect on May 25th 2018. 
Even though the intentions of this law are good, some points are still unclear or difficult to implement.
The fines for non-compliance are up to 20 million Euro, not to mention lawyer fees.<br /><br />

Even though net2ftp is mostly compliant with the GDPR requirements, 
it makes no sense for any business to provide a service free of charge when the risks are that high.
We have decided to stop offering services to users from the 27 EU countries (including Britain), 
Croatia, Iceland, Liechtenstein and Switzerland, and also block connections to servers in these countries.<br /><br />

You are seeing this message because we have detected that you are visiting this website from 
$user_country_name (derived from your IP address " . $net2ftp_globals["REMOTE_ADDR"] . ").
				", debug_backtrace(), __FILE__, __LINE__);
				return false;
			}
		}

	} // end if($net2ftp_settings["use_geoblocking"]

// -------------------------------------------------------------------------
// 3) Check if the user's IP address is in the database table of anonymizer services (VPN, proxy, Tor exits)
// -------------------------------------------------------------------------

	if ($net2ftp_settings["use_geoblocking"] == "yes") {

		$sqlquery3 = "SELECT * FROM ip2location_px1 WHERE ip_from <= $user_ipaddress_number AND ip_to >= $user_ipaddress_number LIMIT 1;";

		$result3   = mysqli_query($net2ftp_globals["mysqli_link"], "$sqlquery3");
		if ($result3 == false) { 
			setErrorVars(false, "Unable to execute SQL SELECT query (checkAuthorization > sqlquery3) <br /> $sqlquery3", debug_backtrace(), __FILE__, __LINE__);
			return false; 
		}

		$nrofrows3 = mysqli_num_rows($result3);

		mysqli_free_result($result3);

		if ($nrofrows3 > 0) {
			setErrorVars(false, "
The European Union's \"General Data Protection Regulation\" (GDPR) has taken effect on May 25th 2018. 
Even though the intentions of this law are good, some points are still unclear or difficult to implement.
The fines for non-compliance are up to 20 million Euro, not to mention lawyer fees.<br /><br />

Even though net2ftp is mostly compliant with the GDPR requirements, 
it makes no sense for any business to provide a service free of charge when the risks are that high.
We have decided to stop offering services to users from the 27 EU countries (including Britain), 
Croatia, Iceland, Liechtenstein and Switzerland, and also block connections to servers in these countries.<br /><br />

You are seeing this message because we have detected that you are visiting this website using 
an anonymizing service (VPN, proxy, Tor) (derived from your IP address " . $net2ftp_globals["REMOTE_ADDR"] . ").
			", debug_backtrace(), __FILE__, __LINE__);
			return false; 
		}

	} // end if($net2ftp_settings["use_geoblocking"]


// -------------------------------------------------------------------------
// 4) Check if the user's IP address is in the list of allowed IP addresses
// -------------------------------------------------------------------------
	if ($net2ftp_settings["allowed_addresses"][1] != "ALL") {
		$result4 = false;
		for ($i=1; $i<=sizeof($net2ftp_settings["allowed_addresses"]); $i++) {
			if (checkIPinNetwork($net2ftp_globals["REMOTE_ADDR"], $net2ftp_settings["allowed_addresses"][$i]) == true) { $result4 = true; break 1; }
		}
		if ($result4 == false) {
			$errormessage = __("Your IP address (%1\$s) is not in the list of allowed IP addresses.", $net2ftp_globals["REMOTE_ADDR"]);
			setErrorVars(false, $errormessage, debug_backtrace(), __FILE__, __LINE__);
			return false;
		}
	}


// -------------------------------------------------------------------------
// 5) Check if the user's IP address is in the list of banned IP addresses
// -------------------------------------------------------------------------
	if (isset($net2ftp_settings["banned_addresses"][1]) == true && $net2ftp_settings["banned_addresses"][1] != "NONE") {
		$result5 = false;
		for ($i=1; $i<=sizeof($net2ftp_settings["banned_addresses"]); $i++) {
			if (checkIPinNetwork($net2ftp_globals["REMOTE_ADDR"], $net2ftp_settings["banned_addresses"][$i]) == true) { $result5 = true; break 1; }
		}
		if ($result5 == true) {
			$errormessage = __("Your IP address (%1\$s) is in the list of banned IP addresses.", $net2ftp_globals["REMOTE_ADDR"]);
			setErrorVars(false, $errormessage, debug_backtrace(), __FILE__, __LINE__);
			return false;
		}
	}


// -------------------------------------------------------------------------
// 6) Check if the FTP server's country (derived from the FTP server's IP address) in the list of banned countries
// -------------------------------------------------------------------------

	if ($ftpserver != "" && $net2ftp_settings["use_geoblocking"] == "yes") {

// Determine the FTP server's country based on his IP address
		$sqlquery6 = "SELECT * FROM ip2location_db1 WHERE ip_to >= $ftpserver_ipaddress_number LIMIT 1;";

		$result6   = mysqli_query($net2ftp_globals["mysqli_link"], "$sqlquery6");
		if ($result6 == false) { 
			setErrorVars(false, "Unable to execute SQL SELECT query (checkAuthorization > sqlquery6) <br /> $sqlquery6", debug_backtrace(), __FILE__, __LINE__);
			return false; 
		}

		$resultRow6 = mysqli_fetch_object($result6); 
		$ftpserver_country_code = $resultRow6->country_code;
		$ftpserver_country_name = $resultRow6->country_name;
		$net2ftp_globals["ftpserver_country"] = $ftpserver_country_code;

		mysqli_free_result($result6);

// Check if user's country is allowed or blocked
		for ($i = 1; $i <= sizeof($net2ftp_settings["geoblock"]); $i++) {
			if ($ftpserver_country_code == $net2ftp_settings["geoblock"][$i]) { 
			setErrorVars(false, "
The European Union's \"General Data Protection Regulation\" (GDPR) has taken effect on May 25th 2018. 
Even though the intentions of this law are good, some points are still unclear or difficult to implement.
The fines for non-compliance are up to 20 million Euro, not to mention lawyer fees.<br /><br />

Even though net2ftp is mostly compliant with the GDPR requirements, 
it makes no sense for any business to provide a service free of charge when the risks are that high.
We have decided to stop offering services to users from the 27 EU countries (including Britain), 
Croatia, Iceland, Liechtenstein and Switzerland, and also block connections to servers in these countries.<br /><br />

You are seeing this message because we have detected that you are trying to connect to a server in  
$ftpserver_country_name (derived from the server's IP address " . $ftpserver_ipaddress . ").
			", debug_backtrace(), __FILE__, __LINE__);
				return false;
			}
		} // end for

	} // end if($ftpserver ... $net2ftp_settings["use_geoblocking"]


// -------------------------------------------------------------------------
// 7) Check if the FTP server is in the list of those that may be accessed
// -------------------------------------------------------------------------
	if ($net2ftp_settings["allowed_ftpservers"][1] != "ALL") {
		$result7 = array_search($ftpserver, $net2ftp_settings["allowed_ftpservers"]);
		if ($result7 == false) {
			$errormessage = __("The FTP server <b>%1\$s</b> is not in the list of allowed FTP servers.", $ftpserver);
			setErrorVars(false, $errormessage, debug_backtrace(), __FILE__, __LINE__);
			return false;
		}
	}


// -------------------------------------------------------------------------
// 8) Check if the FTP server is in the list of those that may NOT be accessed
// -------------------------------------------------------------------------
	if (isset($net2ftp_settings["banned_ftpservers"][1]) == true && $net2ftp_settings["banned_ftpservers"][1] != "NONE") {
		$result8 = array_search($ftpserver, $net2ftp_settings["banned_ftpservers"]);
		if ($result8 != false) {
			$errormessage = __("The FTP server <b>%1\$s</b> is in the list of banned FTP servers.", $ftpserver);
			setErrorVars(false, $errormessage, debug_backtrace(), __FILE__, __LINE__);
			return false;
		}
	}


// -------------------------------------------------------------------------
// 9) Check if the FTP server port is OK
// -------------------------------------------------------------------------
// Do not perform this check if ALL ports are allowed
	if ($net2ftp_settings["allowed_ftpserverport"] != "ALL" ) {
// Report the error if another port nr has been entered than the one which is allowed
		if ($ftpserverport != $net2ftp_settings["allowed_ftpserverport"]) {
			$errormessage = __("The FTP server port %1\$s may not be used.", $ftpserverport);
			setErrorVars(false, $errormessage, debug_backtrace(), __FILE__, __LINE__);
			return false;
		}
	}

// -------------------------------------------------------------------------
// 10) Check if the directory is authorised: whether the current $directory name contains a banned keyword.
//     The rootdirectory is first checked for the current user; if this is not set, 
//     the default rootdirectory is checked.
// -------------------------------------------------------------------------
	$result10 = checkAuthorizedDirectory($directory);
	if ($result10 == false) {
		$net2ftp_globals["directory_html"] = htmlEncode2($net2ftp_globals["directory"]);
		$net2ftp_globals["directory_js"]   = javascriptEncode2($net2ftp_globals["directory"]);
		if (strlen($net2ftp_globals["directory"]) > 0) { $net2ftp_globals["printdirectory"] = $net2ftp_globals["directory"]; }
		else                                           { $net2ftp_globals["printdirectory"] = "/"; }
	}

// -------------------------------------------------------------------------
// 11) Check if the privacy policies were accepted
// -------------------------------------------------------------------------
	if ($net2ftp_globals["state"] != "login" && $net2ftp_globals["state"] != "login_small" && $net2ftp_globals["state"] != "homepage" && $net2ftp_globals["state"] != "clearcookies") {
		for ($i=1; $i<=10; $i++) {
			if (isset($net2ftp_settings["privacy_policy_" . $i]) && $net2ftp_settings["privacy_policy_" . $i] != "") {
				if ($net2ftp_globals["privacy" . $i] != 1) { 
					$errormessage = __("Please agree to all privacy policies.");
					setErrorVars(false, $errormessage, debug_backtrace(), __FILE__, __LINE__);
					return false;
				}
			}
		} // end for
	}

// -------------------------------------------------------------------------
// If everything is OK, return true
// -------------------------------------------------------------------------
	return true;

} // end checkAuthorization

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function Dot2LongIP($IPaddress) {

	if     ($IPaddress == "")    { return 0; }
	elseif ($IPaddress == "::1") { return 0; }  
	else {
		$ips = explode(".", $IPaddress);
		return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256); 
	}

} // end function Dot2LongIP

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function checkAuthorizedDirectory($directory) {

// --------------
// This function checks whether the current $directory name contains a banned 
// keyword.
// --------------

// -------------------------------------------------------------------------
// Global variables
// -------------------------------------------------------------------------
	global $net2ftp_globals, $net2ftp_settings, $net2ftp_result;

// -------------------------------------------------------------------------
// Check if the directory name contains a banned keyword
// -------------------------------------------------------------------------
	if (checkAuthorizedName($directory) == false) { return false; }

	return true;

} // end checkAuthorizedDirectory

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function checkAuthorizedName($dirfilename) {

// --------------
// This function checks if the directory/file/symlink name contains a forbidden keyword
// --------------

// -------------------------------------------------------------------------
// Global variables
// -------------------------------------------------------------------------
	global $net2ftp_settings;

// -------------------------------------------------------------------------
// Check
// -------------------------------------------------------------------------
	if (isset($net2ftp_settings["banned_keywords"][1]) == true && $net2ftp_settings["banned_keywords"][1] != "NONE") {
		for ($i=1; $i<=sizeof($net2ftp_settings["banned_keywords"]); $i++) {
			if (strpos($dirfilename, $net2ftp_settings["banned_keywords"][$i]) !== false) { return false; }
		}
	}

	return true;

} // end checkAuthorizedName

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function isSubdirectory($parentdir, $childdir) {

// --------------
// Returns true if the childdir is a subdirectory of the parentdir
// --------------

// If the parentdir is empty or the root directory, then the childdir is 
// a the same as or a subdirectory of the parentdir
	if ($parentdir == "" || $parentdir == "/" || $parentdir == "\\") { return true; }

// Strip the directories of leading and trailing slashes
	$parentdir = stripDirectory($parentdir);
	$childdir  = stripDirectory($childdir);
	$parentdir_length = strlen($parentdir);

// Check if the first characters of the childdir are different from the 
// parentdir. Example:
//    parentdir: /home/abc
//    childdir:  /home/blabla ==> false
//    childdir:  /home/abcd    ==> continue further checks
//    childdir:  /home/abc/xyz ==> continue further checks
	$childdir_firstchars = substr($childdir, 0, $parentdir_length);
	if ($childdir_firstchars != $parentdir) { return false; }

// If the first characters of the childdir are identical to the parentdir,
// check if the first next character of the childdir name is different. 
// Example:
//    parentdir: /home/abc
//    childdir:  /home/abcd    ==> false
//    childdir:  /home/abc/xyz ==> true
	$childdir_nextchar = substr($childdir, $parentdir_length, 1);
	if ($childdir_nextchar != "/" && $childdir_nextchar != "\\") { return false; }

	return true;
	
} // end isSubdirectory

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function checkAdminUsernamePassword() {

// --------------
// This function checks the Administrator username and password.
// If one of the two is not filled in or incorrect, a header() is sent
// to redirect the user to the login_small page.
// --------------

// -------------------------------------------------------------------------
// Global variables
// -------------------------------------------------------------------------
	global $net2ftp_globals, $net2ftp_settings, $net2ftp_result;
	$input_admin_username = $_POST["input_admin_username"];
	$input_admin_password = $_POST["input_admin_password"];

// -------------------------------------------------------------------------
// Check Admin username and password
// -------------------------------------------------------------------------

// Set the error message depending on the case
// Redirect the user to the login_small page

	// No username or password filled in
	if ($input_admin_username == "" || $input_admin_password == "") {
		$errormessage = htmlEncode2(__("You did not enter your Administrator username or password."));
		header("Location: " . $net2ftp_globals["action_url"] . "?state=login_small&state2=admin&go_to_state=" . $net2ftp_globals["state"] . "&go_to_state2=" . $net2ftp_globals["state2"] . "&errormessage=" . $errormessage);
		$net2ftp_result["exit"] = true;
		return false;
	}

	// Wrong username or password
	elseif ($input_admin_username != $net2ftp_settings["admin_username"] || 
              $input_admin_password != $net2ftp_settings["admin_password"]) {
		$errormessage = htmlEncode2(__("Wrong username or password. Please try again."));
		header("Location: " . $net2ftp_globals["action_url"] . "?state=login_small&state2=admin&go_to_state=" . $net2ftp_globals["state"] . "&go_to_state2=" . $net2ftp_globals["state2"] . "&errormessage=" . $errormessage);
		$net2ftp_result["exit"] = true;
		return false;
	}
	
	return true;

} // end checkAdminUsernamePassword()

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************



?>