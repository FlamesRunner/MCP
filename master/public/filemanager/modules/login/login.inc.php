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

function net2ftp_module_sendHttpHeaders() {

// --------------
// This function sends HTTP headers
// --------------

	global $net2ftp_globals;

	$cookie_expire = time()+60*60*24*30; // 30 days

// Consent cookies
// Set by net2ftp login, login_small and browse modules, and removed by net2ftp clearcookies module
	setcookie("net2ftpcookie_consent_necessary",           $net2ftp_globals["consent_necessary"],           $cookie_expire);
	setcookie("net2ftpcookie_consent_preferences",         $net2ftp_globals["consent_preferences"],         $cookie_expire);
	setcookie("net2ftpcookie_consent_statistics",          $net2ftp_globals["consent_statistics"],          $cookie_expire);
	setcookie("net2ftpcookie_consent_personalized_ads",    $net2ftp_globals["consent_personalized_ads"],    $cookie_expire);
	setcookie("net2ftpcookie_consent_nonpersonalized_ads", $net2ftp_globals["consent_nonpersonalized_ads"], $cookie_expire);

// Necessary cookies
// e.g. for Google Captcha

// Preferences
// Set by net2ftp browse module, and removed by net2ftp clearcookies module

// Statistics
// e.g. for Google Analytics

// Personalized ads
// e.g. for Google Adsense

// Nonpersonalized ads
// e.g. for Google Adsense

} // end net2ftp_sendHttpHeaders

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function net2ftp_module_printJavascript() {

// --------------
// This function prints Javascript code and includes
// --------------

	global $net2ftp_settings, $net2ftp_globals;

// -------------------------------------------------------------------------
// Google Captcha
// See also more code below to allow 3 captchas on the same page
// -------------------------------------------------------------------------

// Recaptcha (special code to allow 3 on the same page)
// http://mycodde.blogspot.ch/2014/12/multiple-recaptcha-demo-same-page.html
	if ($net2ftp_settings["use_captcha"] == "yes") {
		echo "<script src=\"https://www.google.com/recaptcha/api.js?onload=myCallBack&render=explicit\" async defer></script>\n";
	}

// -------------------------------------------------------------------------
// Google adsense
// -------------------------------------------------------------------------
	if ($net2ftp_settings["show_ads"] == "yes") {
		echo "<script async src=\"https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></script>\n";
		echo "<script>\n";
		echo "  (adsbygoogle = window.adsbygoogle || []).push({\n";
		echo "    google_ad_client: \"ca-pub-5170524795218203\",\n";
		echo "    enable_page_level_ads: true\n";
		echo "  });\n";
		echo "</script>\n";
	}

// -------------------------------------------------------------------------
// Code
// -------------------------------------------------------------------------

	echo "<script type=\"text/javascript\"><!--\n";	

// Recaptcha (special code to allow 3 on the same page)
// http://mycodde.blogspot.ch/2014/12/multiple-recaptcha-demo-same-page.html
	if ($net2ftp_settings["use_captcha"] == "yes") {
		echo "var recaptcha1, recaptcha2, recaptcha3;\n";
		echo "var myCallBack = function() {\n";
		echo "	recaptcha1 = grecaptcha.render('recaptcha1', {\n";
		echo "		'sitekey' : '" . $net2ftp_settings["recaptcha_sitekey"] . "',\n";
		echo "		'theme' : 'light'\n";
		echo "	});\n";
		echo "	recaptcha2 = grecaptcha.render('recaptcha2', {\n";
		echo "		'sitekey' : '" . $net2ftp_settings["recaptcha_sitekey"] . "',\n";
		echo "		'theme' : 'light'\n";
		echo "	});\n";
		echo "	recaptcha3 = grecaptcha.render('recaptcha3', {\n";
		echo "		'sitekey' : '" . $net2ftp_settings["recaptcha_sitekey"] . "',\n";
		echo "		'theme' : 'light'\n";
		echo "	});\n";
		echo "};\n";
	}

// Check if the user did enter an FTP server and username
	echo "function CheckInput(form) {\n";

	echo "	if (form.ftpserver.value.length == 0) {\n";
	echo "		form.ftpserver.focus();\n";
	echo "		alert(\"" . __("Please enter an FTP server.") . "\");\n";
	echo "		return false;\n";
	echo "	}\n";
	echo "	if (form.ftpserver.value.length > 254) {\n";
	echo "		form.ftpserver.focus();\n";
	echo "		alert(\"" . __("FTP server name is too long; please enter less than 255 characters.") . "\");\n";
	echo "		return false;\n";
	echo "	}\n";

	echo "	if (form.username.value.length == 0) {\n";
	echo "		form.username.focus();\n";
	echo "		alert(\"" . __("Please enter a username.") . "\");\n";
	echo "		return false;\n";
	echo "	}\n";
	echo "	if (form.username.value.length > 254) {\n";
	echo "		form.username.focus();\n";
	echo "		alert(\"" . __("Username is too long; please enter less than 255 characters.") . "\");\n";
	echo "		return false;\n";
	echo "	}\n";

//	echo "	if (form.password.value.length == 0) {\n";
//	echo "		form.password.focus();\n";
//	echo "		alert(\"" . __("Please enter a password.") . "\");\n";
//	echo "		return false;\n";
//	echo "	}\n";

	echo "	if (form.user_email.value.length == 0) {\n";
	echo "		form.user_email.focus();\n";
	echo "		alert(\"" . __("Please enter your email address.") . "\");\n";
	echo "		return false;\n";
	echo "	}\n";
	echo "	if (form.user_email.value.length > 254) {\n";
	echo "		form.user_email.focus();\n";
	echo "		alert(\"" . __("Email is too long; please enter less than 255 characters.") . "\");\n";
	echo "		return false;\n";
	echo "	}\n";

	$privacy_check = "";
	for ($i=1; $i<=10; $i++) {
		if (isset($net2ftp_settings["privacy_policy_" . $i]) && $net2ftp_settings["privacy_policy_" . $i] != "") { 
			$privacy_check .= " || form.privacy" . $i . ".checked == false"; 
		} // end if
	} // end for
	$privacy_check = substr($privacy_check, 4, strlen($privacy_check)-4);

	echo "	if (" . $privacy_check . ") {\n";
	echo "		alert(\"" . __("Please agree to all privacy policies.") . "\");\n";
	echo "		return false;\n";
	echo "	}\n";

	echo "	return true;\n";
	echo "}\n";

// Get server's fingerprint
	echo "function GetFingerprint(form) {\n";
	echo "	result = CheckInput(form);\n";
	echo "	if (result == true) {\n";
	echo "		form.sshfingerprint.value = \"" . __("Getting fingerprint, please wait...") . "\";\n";
	echo "		var http = new XMLHttpRequest();\n";
	echo "		var url = \"index.xml.php\";\n";
	echo "		var params = \"protocol=FTP-SSH&ftpserver=\" + form.ftpserver.value + \"&state=serverfingerprint\";\n";
	echo "		http.open(\"POST\", url, true);\n";
//Send the proper header information along with the request
	echo "		http.setRequestHeader(\"Content-type\", \"application/x-www-form-urlencoded\");\n";
//Call a function when the state changes
	echo "		http.onreadystatechange = function() {\n";
	echo "			if(http.readyState == 4 && http.status == 200) {\n";
	echo "	        		form.sshfingerprint.value = http.responseText;\n";
	echo "			}\n";
	echo "			else {\n";
	echo "				form.sshfingerprint.value = \"" . __("Could not get fingerprint") . "\";\n";
	echo "			}\n";
	echo "		}\n";
	echo "		http.send(params);\n";
	echo "	}\n";
	echo "}\n";

// Protocol drop-down box: 
// When changing the protocol, fill in the default port number of that protocol
	echo "function do_protocol(form) {\n";
	echo "	var protocol = form.protocol.value;\n";
	echo "	if (protocol == \"FTP\") {\n";
	echo "		form.ftpserverport.value = \"21\"\n";
	echo "	}\n";
	echo "	else if (protocol == \"FTP-SSH\") {\n";
	echo "		form.ftpserverport.value = \"22\";\n";
	echo "	}\n";
	echo "	else if (protocol == \"FTP-SSL\") {\n";
	echo "		form.ftpserverport.value = \"990\";\n";
	echo "	}\n";
	echo "	return true;\n";
	echo "}\n";

// Anonymous checkbox:
// - When setting the flag: fill in username "anonymous" and password "user@net2ftp.com"
// - When unsetting the flag: restore the username and password which were previously filled in
	echo "function do_anonymous(form) {\n";
	echo "	var checked = form.anonymous.checked;\n";
	echo "	if (checked == true) {\n";
	echo "		last_username = form.username.value;\n";
	echo "		last_password = form.password.value;\n";
	echo "		form.username.value = \"anonymous\";\n";
	echo "		form.password.value = \"user@net2ftp.com\";\n";
	echo "	} else {\n";
	echo "		form.username.value = last_username;\n";
	echo "		form.password.value = last_password;\n";
	echo "	}\n";
	echo "	return true;\n";
	echo "}\n";
	
// Clear Cookies
	echo "function ClearCookies() {\n";
	echo "	document.forms['LoginForm'].state.value='clearcookies';\n";
	echo "	document.forms['LoginForm'].state2.value='';\n";
	echo "	document.forms['LoginForm'].submit();\n";
	echo "}\n";


	echo "//--></script>\n";

} // end net2ftp_printJavascript

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function net2ftp_module_printCss() {

// --------------
// This function prints CSS code and includes
// --------------

	global $net2ftp_settings, $net2ftp_globals;

//	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"". $net2ftp_globals["application_rootdir_url"] . "/skins/" . $net2ftp_globals["skin"] . "/css/main.css.php?ltr=" . __("ltr") . "&amp;image_url=" . urlEncode2($net2ftp_globals["image_url"]) . "\" />\n";

} // end net2ftp_printCssInclude

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function net2ftp_module_printBodyOnload() {

// --------------
// This function prints the <body onload="" actions
// --------------

//	global $net2ftp_settings, $net2ftp_globals, $net2ftp_messages, $net2ftp_result;
//	echo "";

} // end net2ftp_printBodyOnload

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function net2ftp_module_printBody() {

// --------------
// This function prints the login screen
// --------------

// -------------------------------------------------------------------------
// Global variables
// -------------------------------------------------------------------------
	global $net2ftp_settings, $net2ftp_globals, $net2ftp_messages, $net2ftp_result;

// -------------------------------------------------------------------------
// Variables
// -------------------------------------------------------------------------

// ------------------------------------
// Header
// ------------------------------------
	if ($net2ftp_globals["browser_platform"] == "Mobile")	{ $header_height = "50px"; }
	else 									{ $header_height = "180px"; }

// ------------------------------------
// Title
// ------------------------------------
	$login_title = __("Login!");

// ------------------------------------
// FTP server
//	    $ftpserver["inputType"] can be "text", "select" or "hidden"
//	    $ftpserver"][$i]["text"] is "ftp.server.com"
//	    $ftpserver"][$i]["selected"] is "selected" or ""
// ------------------------------------

// All FTP servers are allowed
// Prefill the textbox with the value that was filled in (when changing the language the page refreshes)
// or else with the value from the cookie
    	if ($net2ftp_settings["allowed_ftpservers"][1] == "ALL") {
		// Input type is textbox
    		$ftpserver["inputType"] = "text";

		// Prefill with the previous input value
		if ($net2ftp_globals["ftpserver"] != "") { $ftpserver["list"][1] = htmlEncode2($net2ftp_globals["ftpserver"]); }

		// Prefill with the cookie value
    		else { $ftpserver["list"][1] = htmlEncode2($net2ftp_globals["cookie_ftpserver"]); }
    	}
	
// Only a list of FTP servers are allowed
// Preselect the drop-down box with the value that was filled in (when changing the language the page refreshes)
// or else with the value from the cookie
	elseif (sizeof($net2ftp_settings["allowed_ftpservers"]) > 1) {
		// Input type is drop-down box
		$ftpserver["inputType"] = "select";

		// List of allowed FTP servers
		$ftpserver["list"] = $net2ftp_settings["allowed_ftpservers"];

		// Preselect the right FTP server
		// ... using the previous input value
		$array_search_result1 = array_search($net2ftp_globals["ftpserver"], $ftpserver);
		if (is_numeric($array_search_result1) == true) { $ftpserver["list"][$array_search_result1]["selected"] = "selected=\"selected\""; }

		// ... using the cookie value
		else {
			$array_search_result2 = array_search($net2ftp_globals["cookie_ftpserver"], $ftpserver);
			if (is_numeric($array_search_result2) == true) { $ftpserver["list"][$array_search_result2]["selected"] = "selected=\"selected\""; }
		}
	}

// Only 1 FTP server is allowed
	elseif (sizeof($net2ftp_settings["allowed_ftpservers"]) == 1) {
		$ftpserver["inputType"] = "hidden";
		$ftpserver["list"][1] = $net2ftp_settings["allowed_ftpservers"][1];
	}
	
// Else, there is an error!
	else {
		$errormessage = "There is an error in the net2ftp configuration file <b>settings_authorizations.inc.php</b>: variable <b>\$net2ftp_allowed_ftpservers</b> does not follow the expected format.";
		setErrorVars(false, $errormessage, debug_backtrace(), __FILE__, __LINE__);
		return false;
	}


// ------------------------------------
// FTP server port
//	    $ftpserverport["inputType"] can be "text" or "hidden"
//	    $ftpserverport is "21"
// ------------------------------------
		
	if ($net2ftp_settings["allowed_ftpserverport"] == "ALL") {
		// Input type is textbox
		$ftpserverport["inputType"] = "text";

		// Prefill with the previous input value
		if ($net2ftp_globals["ftpserverport"] != "") { 
			$ftpserverport["defaultvalue_ftp"] = htmlEncode2($net2ftp_globals["ftpserverport"]); 
			$ftpserverport["defaultvalue_ssh"] = htmlEncode2($net2ftp_globals["ftpserverport"]); 
			$ftpserverport["defaultvalue_ssl"] = htmlEncode2($net2ftp_globals["ftpserverport"]); 
		}
		else { 
		// Prefill with the cookie value - only if it is different from empty
			if ($net2ftp_globals["cookie_ftpserverport_ftp"] != "") { $ftpserverport["defaultvalue_ftp"] = htmlEncode2($net2ftp_globals["cookie_ftpserverport_ftp"]); }
			else 									  { $ftpserverport["defaultvalue_ftp"] = 21; }
			if ($net2ftp_globals["cookie_ftpserverport_ssh"] != "") { $ftpserverport["defaultvalue_ssh"] = htmlEncode2($net2ftp_globals["cookie_ftpserverport_ssh"]); }
			else 									  { $ftpserverport["defaultvalue_ssh"] = 22; }
			if ($net2ftp_globals["cookie_ftpserverport_ssl"] != "") { $ftpserverport["defaultvalue_ssl"] = htmlEncode2($net2ftp_globals["cookie_ftpserverport_ssl"]); }
			else 									  { $ftpserverport["defaultvalue_ssl"] = 990;}
		}
	}
	
	else {
		$ftpserverport["inputType"] = "hidden";
		$ftpserverport["defaultvalue_ftp"] = $net2ftp_settings["allowed_ftpserverport"];
		$ftpserverport["defaultvalue_ssh"] = $net2ftp_settings["allowed_ftpserverport"];
		$ftpserverport["defaultvalue_ssl"] = $net2ftp_settings["allowed_ftpserverport"];
	}
	

// ------------------------------------
// SSH fingerprint
// ------------------------------------

	// Prefill with the previous input value
	if ($net2ftp_globals["sshfingerprint"] != "") { $sshfingerprint = htmlEncode2($net2ftp_globals["sshfingerprint"]); }

	// Prefill with the cookie value
    	else { $sshfingerprint = htmlEncode2($net2ftp_globals["cookie_sshfingerprint"]); }


// ------------------------------------
// Username
// ------------------------------------

	// Prefill with the previous input value
	if ($net2ftp_globals["username"] != "") { $username = htmlEncode2($net2ftp_globals["username"]); }

	// Prefill with the cookie value
    	else { $username = htmlEncode2($net2ftp_globals["cookie_username"]); }


// ------------------------------------
// Password
// ------------------------------------

	// Do not prefill this field
	$password = "";

// ------------------------------------
// Passive mode
// ------------------------------------

	if     ($net2ftp_globals["passivemode"] == "yes")        { $passivemode["checked"] = "checked=\"checked\""; }
	elseif ($net2ftp_globals["cookie_passivemode"] == "yes") { $passivemode["checked"] = "checked=\"checked\""; }
	else                                                     { $passivemode["checked"] = ""; }


// ------------------------------------
// Initial directory
// ------------------------------------

	if     (strlen($net2ftp_globals["directory"]) > 1)        { $directory = $net2ftp_globals["directory_html"]; }
	elseif (strlen($net2ftp_globals["cookie_directory"]) > 1) { $directory = htmlEncode2($net2ftp_globals["cookie_directory"]); }
	else                                                      { $directory = ""; }

// ------------------------------------
// Protocol
// ------------------------------------

	$protocol["inputType"] = "select"; 
	$protocol["list"][1]["name"]     = "FTP";
	$protocol["list"][1]["value"]    = "FTP";
	$protocol["list"][1]["selected"] = "selected"; 
	$protocol["list"][2]["name"]     = "FTP over SSH2";
	$protocol["list"][2]["value"]    = "FTP-SSH";
	$protocol["list"][2]["selected"] = ""; 
	if (function_exists("ftp_ssl_connect") == true) { 
		array_push($protocol["list"], array("name" => "FTP with SSL", "value" => "FTP-SSL" ,"selected" => ""));
	}

// ------------------------------------
// Language
// ------------------------------------	

	$language_onchange = "document.forms['LoginForm'].state.value='login'; document.forms['LoginForm'].submit();";

// ------------------------------------
// Skin
// ------------------------------------
	
	$skin_onchange = "";
	
// ------------------------------------
// FTP mode
// ------------------------------------

// Determine the FTP mode
	if     ($net2ftp_globals["ftpmode"] != "")        { $ftpmode["type"] = htmlEncode2($net2ftp_globals["ftpmode"]); }
	elseif ($net2ftp_globals["cookie_ftpmode"] != "") { $ftpmode["type"] = htmlEncode2($net2ftp_globals["cookie_ftpmode"]); }
	else { 
		// Before PHP version 4.3.11, bug 27633 can cause problems in ASCII mode ==> use BINARY mode
		if (version_compare(phpversion(), "4.3.11", "<")) { $ftpmode["type"] = "binary"; }
		// As from PHP version 4.3.11, bug 27633 is fixed ==> use Automatic mode
		else                                              { $ftpmode["type"] = "automatic"; }
	}

// Fill the values that will be used in the template
	if ($ftpmode["type"] == "automatic") { 
		$ftpmode["automatic"] = "checked=\"checked\"";
		$ftpmode["binary"] = ""; 
	}
	elseif ($ftpmode["type"] == "binary") { 
		$ftpmode["automatic"] = "";
		$ftpmode["binary"] = "checked=\"checked\"";
	}

// ------------------------------------
// FTP mode
// ------------------------------------

	$admin_url = $net2ftp_globals["action_url"] . "?state=login_small&amp;state2=admin&amp;go_to_state=admin";

// ------------------------------------
// User email 
// ------------------------------------
	if ($net2ftp_globals["cookie_user_email"] != "" && $net2ftp_globals["cookie_user_email"] != "invalid_user_email") { 
		$user_email = $net2ftp_globals["cookie_user_email"]; 
	}
	else { 
		$user_email = ""; 
	}

// ------------------------------------
// Privacy policies
// ------------------------------------
	for ($i=1; $i<=10; $i++) {
		if (isset($net2ftp_settings["privacy_policy_" . $i]) && $net2ftp_globals["cookie_privacy" . $i] == 1) { 
			$privacy_checked[$i] = "checked";
		} // end if
		else {
			$privacy_checked[$i] = "";
		}
	} // end for

// ------------------------------------
// Focus
// ------------------------------------
	if   ($net2ftp_settings["allowed_ftpservers"][1] == "ALL") { $focus = "ftpserver"; }
	else                                                       { $focus = "username"; }

// -------------------------------------------------------------------------
// Print the output
// -------------------------------------------------------------------------
	require_once($net2ftp_globals["application_skinsdir"] . "/" . $net2ftp_globals["skin"] . "/login.template.php");

} // End net2ftp_printBody

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************

?>